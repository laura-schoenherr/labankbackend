<?php
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
   $money = 'money';


   // Perform the select query
   $sql = "SELECT $column FROM $table WHERE $column = $card";

   $result = $conn->query($sql);
   
   if ($result->num_rows > 0) {
    // Value found, now get card_money
    $sql = "SELECT $money FROM $table WHERE $column = $card";
    $moneyresult = $conn->query($sql);

    if ($moneyresult->num_rows > 0) {
        $row = $moneyresult->fetch_assoc();
        echo json_encode(['found' => true, 'card_money' => $row[$money]]);
    } else {
        echo json_encode(['error' => 'Card money not found']);
    }
} else {
    // Perform the insert query
    $sql = "INSERT INTO $table ($column) VALUES ($card)";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(['found' => false, 'inserted' => true, 'value' => $card]);
    } else {
        echo json_encode(['error' => "Error: " . $sql . "<br>" . $conn->error]);
    }

   // $sql = "INSERT INTO tbl_card (card_value) VALUES ($card)";

   $conn->close();
} 

}
?>
