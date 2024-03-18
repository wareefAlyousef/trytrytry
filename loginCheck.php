<?php
session_start();

$connection = mysqli_connect("localhost","root","root","webdb");   
$error = mysqli_connect_error();
if($error != null){
    echo '<p> cant connect to DB';
}             
else{ 
    if(isset($_POST['email']) && isset($_POST['pass']) && isset($_POST['type'])){
        $select = "SELECT * FROM `".$_POST['type']."` WHERE `emailAddress` = ?";
        $stmt = $connection->prepare($select);
        $stmt->bind_param("s", $_POST['email']);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if($result->num_rows > 0) {
            $row = $result->fetch_assoc();
                if(password_verify($_POST['pass'], $row['password'])){
                    $_SESSION["userID"]=$row['id'];
                    $_SESSION["userType"]=$_POST['type'];
                    header('Location:'.$_POST['type'].'HomePage.php'); //change when code is ready
                    exit();
                }
            }
        
        echo '<script> alert("email or password incorrect, please try again"); window.location.href="logIn.html"; </script>';
        exit();
        
    }
}

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

