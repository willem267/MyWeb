<?php
//Tao thong tin ket noi
$host = "localhost";
$dbname="bancard";
$username = "root";
$password = "";

try {
 
  $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  echo "Kết nối thành công";
} catch(PDOException $e) {
  echo "Kết nối thất bại " . $e->getMessage();
}
?>