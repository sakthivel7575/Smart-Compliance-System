<?php
 $section =$_POST['section'];
 $statement =$_POST['statement'];
 $location = $_POST['location'];

 $file = $_FILES['file'];
	
$fileName=$_FILES['file']['name'];
$fileTmpName=$_FILES['file']['tmp_name'];
$fileSize=$_FILES['file']['size'];
$fileError=$_FILES['file']['error'];
$fileType=$_FILES['file']['type'];

$fileExt = explode('.' , $fileName);
$fileActualExt = strtolower(end($fileExt));
$fileNameNew = "";
$allowed = array('jpg','jpeg', 'png', 'pdf', 'mp4');

if(in_array($fileActualExt, $allowed))
{
	if($fileError === 0)
	{
		if($fileSize < 10000000000)
		{
			$fileNameNew = $fileName;
			$fileDestination = "Uploads/";
			move_uploaded_file($fileTmpName, $fileDestination . $fileNameNew);	
		}
		else
	    {
			echo "Your file is too big!";
			exit(0);
		}
			
	}
	else
    {
		echo "There was an error uploading your file!";
		exit(0);
	}
			
}
else
{
	echo "You cannot upload files of this type!";
	exit(0);
}
 

 //database connection
 $conn = new mysqli('localhost','root','','complaints');
 if($conn->connect_error){
    die('Connection Failed :'.$conn->connect_error);    
 }
 else{
    $stmt = $conn->prepare("insert into complaints (section,statement,location,proof)
 values(?,?,?,?)");
 $stmt->bind_param("ssss",$section,$statement,$location,$fileNameNew);
 $stmt->execute();
 $stmt->close();
 $conn->close();

 }
 ?>