<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="view.css">
    <title>View Page</title>
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
            <li class="nav-item" id="profile-link">
                <a href="javascript:void(0);" class="nav-link" id="profile-icon">&#x1F464; Profile</a>
            </li>
        </ul>
    </nav>
    <div id="user-details" class="user-details-box">
        <p id="user_name"></p>
        <p id="email"></p>
        <p id="contact"></p>
    </div>
    <div class="panel-heading">
         <h1>Complai<span>nts</span></h1><hr><br>
         </div>
         
         <?php
         
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "complaints";
     
        $conn = mysqli_connect($servername, $username, $password, $dbname);
     
        if(!$conn)
        {
            echo "Databse connection failed..! Try again Later";
        }

        $sql = "SELECT * FROM complaints";

        if($result = mysqli_query($conn, $sql))
        {
            if(mysqli_num_rows($result)>0)
            {
                while($row = mysqli_fetch_array($result))
                {
                    $img_src = "uploads/" . $row['proof'];
                    $section = $row['section'];
                    $statement = $row['statement'];
                    $location = $row['location'];

                    $fileExt = explode('.' , $img_src);
                    $fileActualExt = strtolower(end($fileExt));
                    if($fileActualExt == "mp4")
                    {
                        echo "<div class='container1'>       
                        <video
                        controls='controls'/>
                         
                        <source src=$img_src type='video/mp4'>
                        </video>
                        <div>
                            <p><h4>section:</h4> $section </p>
                            <p><h4>statement:</h4> $statement </p>
                            <h4>location:$location</h4>
                        </div>
                    </div>";
                    }
                    else{
                    echo "<div class='container1'>       
                        <img src=$img_src alt='complaint1'>
                        <div>
                            <p><h4>section:</h4> $section </p>
                            <p><h4>statement:</h4> $statement </p>
                            <h4>location:$location</h4>
                        </div>
                    </div>";
                    }
                }
            }
            else
            {
                echo "There is no complaints!";
            }
        }
        else
        {
            echo "Query failure!";
        }


        ?>
    <script>
    const profileLink = document.getElementById('profile-link');
    const userDetails = document.getElementById('user-details');

    profileLink.addEventListener('click', () => {
        if (userDetails.style.display === 'none' || userDetails.style.display === '') {
            userDetails.style.display = 'block';
        } else {
            userDetails.style.display = 'none';
        }
    });

    window.addEventListener('load', () => {
        const userName = getCookie("user_name");
        let email = getCookie("email");
        email = email.replace('%40', '@');
        const contactNo = getCookie("contact_no");
        document.getElementById("user_name").innerHTML = userName;
        document.getElementById("email").innerHTML = email;
        document.getElementById("contact").innerHTML = contactNo;
    });

    function getCookie(name) {
        const cookies = document.cookie.split('; ');
        for (let i = 0; i < cookies.length; i++) {
            const cookie = cookies[i].split('=');
            if (cookie[0] === name) {
                return cookie[1];
            }
        }
        return null;
    }
</script>
</body>
</html>