<?php

if(isset($_GET["card"])) {
   $card = $_GET["card"]; // get cardID from HTTP GET

   $servername = "localhost";
   $username = "Arduino";
   $password = "ArduinoGetStarted.com";
   $dbname = "db_arduino";

   // Create connection
   $conn = new mysqli($servername, $username, $password, $dbname);
   // Check connection
   if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
   }

   $table = 'tbl_card';
   $column = 'card_value';

   // Perform the select query
   $sql = "SELECT $column FROM $table WHERE $column = $card";
   

   // Debugging: Print the SQL query
   echo "Executing query: $sql<br>";

   $result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "Value found, skipping insert.";
} else {
    // Perform the insert query
    $sql = "INSERT INTO $table ($column) VALUES ($card)";
    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

   // $sql = "INSERT INTO tbl_card (card_value) VALUES ($card)";

   $conn->close();
} 
//else {
  // echo "card is not set";
}
?>