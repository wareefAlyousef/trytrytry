<?php
session_start();

$connection = mysqli_connect("localhost","root","root","webdb");   
$error = mysqli_connect_error();
if($error != null){
    echo '<p> cant connect to DB';
}             
else{ 
    
    if(isset($_POST['email'])){
        $select = "SELECT * FROM `client` WHERE `emailAddress` = ?";
        $stmt = $connection->prepare($select);
        $stmt->bind_param("s", $_POST['email']);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows > 0) {
            echo '<script> alert("this email is already being used, please log in instead"); window.location.href="logIn.html"; </script>';
            exit();
        }
    }
        
    if (isset($_POST['fname']) && isset($_POST['lname']) && isset($_POST['email']) && isset($_POST['pass']) ) {
        $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);
        
        $sql = "INSERT INTO `client` (`firstName`, `lastName`, `emailAddress`, `password`) VALUES (?, ?, ?, ?)";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("ssss", $_POST['fname'], $_POST['lname'], $_POST['email'], $pass);
        $stmt->execute();
        $lastInsertedID =$stmt->insert_id;
        $_SESSION["userID"]=$lastInsertedID;
        $_SESSION["userType"]='client';
        
        header('Location:clientHomePage.php'); //change when code is ready
    }
}



        
       
        

    
?>