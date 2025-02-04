<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = "localhost";
$user = "root"; 
$password = ""; 
$database = "food_order_db";


$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $number = $_POST['number'];
    $food_name = $_POST['food_name'];
    $address = $_POST['address'];

    echo "Data received:<br>";
    echo "Name: $name<br>";
    echo "Email: $email<br>";
    echo "Number: $number<br>";
    echo "Food Name: $food_name<br>";
    echo "Address: $address<br>";

    
    $stmt = $conn->prepare("INSERT INTO orders (name, email, number, food_name, address) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $email, $number, $food_name, $address);

   
    if ($stmt->execute()) {
        echo "Redirecting to thankyou.html..."; 
        header("Location: thankyou.html");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }}


$conn->close();
?>
