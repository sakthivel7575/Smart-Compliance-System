<?php
$name = $_POST['user_name'];
$password = $_POST['password'];
echo $name;
echo $password;

$con = new mysqli('localhost','root','','register');
if($con->connect_error){
    die("Failed to connect:".$con->connect_error);
}
else{
    $stmt = $con->prepare("select * from users where username =?");
    $stmt->bind_param("s",$name);
    $stmt->execute();
    $stmt_result = $stmt->get_result();
    if($stmt_result->num_rows > 0) {
        $data = $stmt_result->fetch_assoc(); 
        if ($data['password'] === $password) {
          
            setcookie("user_name", $name, time() + 3600, "/"); 
            setcookie("email", $data['emailid'], time() + 3600, "/"); 
            setcookie("contact_no", $data['contactno'], time() + 3600, "/");
            header("location: " . "rules.html");
            echo "<h2>Login successfully</h2>";
        } else {
            echo "<h2>Invalid Username or password</h2>";
        }
        
    }
    else{
        echo"<h2>Invalid Username or password</h2>";
    }
}
?>