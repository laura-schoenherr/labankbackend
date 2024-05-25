<?php
// Allow access from any origin
header('Access-Control-Allow-Origin: *');
// Allow specific HTTP methods
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
// Allow specific HTTP headers
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    // Respond to preflight requests
    exit(0);
}

header('Content-Type: application/json');

if(isset($_GET["card"])) {
   $card = $_GET["card"]; // get cardID from HTTP GET

   $servername = "localhost";
   $username = "USER";
   $password = "PASSWORD";
   $dbname = "DATABASE";

   // Create connection
   $conn = new mysqli($servername, $username, $password, $dbname);
   // Check connection
   if ($conn->connect_error) {
        die(json_encode(['error' => "Connection failed: " . $conn->connect_error]));
   }

   $table = 'tbl_card';
   $column = 'card_value';
   $money_column = 'money';

   // Perform the select query
   $sql = "SELECT $column, $money_column FROM $table WHERE $column = $card";
   
   $result = $conn->query($sql);

   if ($result->num_rows > 0) {
       $row = $result->fetch_assoc();
       
       if (!isset($row[$money_column])) {
           die(json_encode(['error' => "Column $money_column not found in the result"]));
       }
       
       $card_money = $row[$money_column];

       // Check if withdrawal amount is provided
       if ($_SERVER['REQUEST_METHOD'] === 'POST') {
           $data = json_decode(file_get_contents('php://input'), true);
           if (isset($data["amount"])) {
               $amount = (int)$data["amount"];

               // Check if there is enough money
               if ($card_money >= $amount) {
                   // Reduce the money value
                   $new_money = $card_money - $amount;
                   $update_sql = "UPDATE $table SET $money_column = $new_money WHERE $column = $card";
                   if ($conn->query($update_sql) === TRUE) {
                       echo json_encode(['success' => true, 'new_money' => $new_money, 'card' => $card]);
                   } else {
                       echo json_encode(['error' => "Error updating record: " . $conn->error]);
                   }
               } else {
                   echo json_encode(['error' => 'Insufficient funds']);
               }
           } else {
               echo json_encode(['error' => 'Amount not provided']);
           }
       } else {
           // Return the current money value
           echo json_encode(['found' => true, 'card_money' => $card_money, 'card' => $card]);
       }
   } else {
       // Perform the insert query
       $sql = "INSERT INTO $table ($column) VALUES ($card)";
       if ($conn->query($sql) === TRUE) {
           echo json_encode(['found' => false, 'inserted' => true, 'value' => $card]);
       } else {
           echo json_encode(['error' => "Error: " . $sql . "<br>" . $conn->error]);
       }
   }

   // Close the connection
   $conn->close();
} else {
   echo json_encode(['error' => 'Card parameter missing']);
}
?>
