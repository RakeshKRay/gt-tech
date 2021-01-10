<?php

$name=$_POST["name1"];
$email=$_POST["email1"];
$mobile=$_POST["mobile1"];
$message=$_POST["query1"];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "INSERT INTO `contact`(`name`, `email`, `mobile`, `message`) VALUES ('".$name."','".$email."','".$mobile."','".$message."')";

if ($conn->query($sql) === TRUE) {
    echo "<span class='alert alert-success text-center'>Submitted SuccessFully ✅</span>";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();


// echo "<span class='alert alert-success text-center'>Submitted SuccessFully ✅</span>";



?>