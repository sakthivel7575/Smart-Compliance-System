<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "admin";

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = test_input($_POST['username']);
    $password = test_input($_POST['password']);


    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();


        if ($password == $data['password']) {

            $_SESSION['user_id'] = $data['user_id'];
            $_SESSION['username'] = $name;
            setcookie("user_name", $name, time() + 3600, "/"); 
            setcookie("email", $data['email'], time() + 3600, "/"); 


            header("Location: view.php");
            exit();
        } else {
            $login_error = "Invalid username or password";
        }
    } else {
        $login_error = "Invalid username or password";
    }

    $stmt->close();
}


$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: black;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;

        }

        .login-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }

        input {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            box-sizing: border-box;
        }

        button {
            background-color: #4caf50;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }

        button:hover {
            background-color: #45a049;
        }
        .navbar {
	position: fixed;
	top: 0;
	left: 0;
	z-index: 100; 
	height: 60px;
	width: 100%;
	background-color: #141313;
	color: #fff;
	border-radius: 3px;
	display: flex;
	justify-content: space-between;
	align-items: center;
    box-shadow: 5px 5px 20px rgb(111, 109, 109) ;
}
.navbar-nav {
	display: flex;
	flex-direction: row;
	padding: 0;
	margin: 0;
	list-style: none;
}

.nav-item {
	margin: 0;
}

.nav-title {
	padding-left: 40px;
}

.nav-link {
	display: block;
	padding: 15px;
	color: white;
	text-decoration: none;
	font-weight: 600;
	transition: background-color 0.3s ease;
	padding-top: 20px;
}

.nav-link:hover {
	color: #c86a6a;
}

    </style>
</head>
<body>
    
	<nav class="navbar">
		<h1 class="nav-title">PUBLIC <span>PREFERENCE</span></h1>
		<ul class="navbar-nav">
			<li class="nav-item">
				<a href="#section1" class="nav-link">Home</a>
			</li>
			<li class="nav-item">
				<a href="#section2" class="nav-link">About</a>
			</li>
			<li class="nav-item">
				<a href="#section3" class="nav-link">Services</a>
			</li>
			
		</ul>
	</nav>

<div class="login-container">
    <h2>Admin Login</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Login</button>
    </form>

    <?php
    if (isset($login_error)) {
        echo '<p style="color: red;">' . $login_error . '</p>';
    }
    ?>

</div>

</body>
</html>
