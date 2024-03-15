<?php
session_start();

$connection = mysqli_connect("localhost","root","root","webdb");   
$error = mysqli_connect_error();
if($error != null){
    echo '<p> cant connect to DB';
}             
else{ 
    
    if(isset($_POST['email']) && $_POST['submit']){
       $select = "SELECT * FROM `designer` WHERE `emailAddress` = ?";
        $stmt = $connection->prepare($select);
        $stmt->bind_param("s", $_POST['email']);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows > 0) {
            echo '<script> alert("this email is already being used, please log in instead"); window.location.href="logIn.html"; </script>';
            exit();
        }
    }
        
    if (isset($_POST['fname']) && isset($_POST['lname']) && isset($_POST['email']) && isset($_POST['pass']) && isset($_POST['bname']) && isset($_POST['speciality']) && isset($_POST['submit']) && isset($_FILES["logo"]) && $_FILES["logo"]["error"] == 0) {
        $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);
        
          //do image
        $temp_name = $_FILES['logo']['tmp_name'];
        $path_parts = pathinfo($_FILES["logo"]["name"]); //  to change file name
        $extension = $path_parts['extension']; //get extension
        $filenewname=$_POST['email'].".".$extension; // newname.extension
        $folder = "images/".$filenewname; //create path to put image

      if (move_uploaded_file($temp_name, $folder)) {
            //finishes image
        
       
        
        $sql = "INSERT INTO `designer` (`firstName`, `lastName`, `emailAddress`, `password`, `brandName`, `logoImgFileName`) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("ssssss", $_POST['fname'], $_POST['lname'], $_POST['email'], $pass, $_POST['bname'],$filenewname);
        $stmt->execute();
        $lastInsertedID =$stmt->insert_id;
        $_SESSION["userID"]=$lastInsertedID;
        $_SESSION["userType"]='designer';

        foreach ($_POST['speciality'] as $id => $value){
        $sql = "INSERT INTO `designerspeciality` (`designerID`, `designCategoryID`) VALUES ('$lastInsertedID', '$value')";
        $query = $connection->query($sql); }
        
        
        header('Location:designerHomePage.html'); //change when code is ready
        exit();
        
        }else{

        echo "Failed to upload image";}
        
    }
}
?>


