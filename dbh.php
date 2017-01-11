<?php

$conn = mysqli_connect("localhost", "root", "", "ottelu");

if (!$conn) {
      die("Connection failed: ".mysqli_connect_error());
      }


/*

try {
  $conn = new PDO('mysql:host=localhost;dbname=root', "ottelu", "");
} catch (PDOException $e){
  print "Error!: " . $e->getMessage() . "<br/>";
  die();
}

*/

?>
