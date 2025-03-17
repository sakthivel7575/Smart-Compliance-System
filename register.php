<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $emailid = $_POST['emailid'];
    $contactno = $_POST['contactno'];
    $password = $_POST['password'];

    
    $conn = new mysqli('localhost', 'root', '', 'register');

    if ($conn->connect_error) {
        die('Connection Failed: ' . $conn->connect_error);
    }


    $stmt = $conn->prepare("INSERT INTO users (username, emailid, contactno, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $emailid, $contactno, $password);

    if ($stmt->execute()) {
        echo "Registration Successful!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
