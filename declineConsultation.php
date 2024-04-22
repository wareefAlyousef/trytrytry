<?php
session_start();

include 'databaseConnection.php';

if($error != null){
    echo '<p> cant connect to DB';
}             
else{  
    if (!isset($_SESSION['userID'])) {
            echo "<script>alert('You are not logged in, please login or sign up first');</script>";
            echo "<script>window.location = 'index.php';</script>";
            exit();
    }
    
    if(!isset($_SESSION['userType']) || $_SESSION['userType']=="client") {
        echo "<script> alert('You do not have access to this page');</script>";
        echo "<script>window.location = 'clientHomepage.php';</script>"; 
    }    
    
    if (isset($_POST['edit_row'])) {
    $row_id=$_POST['row_id'];
    $upQuery = "UPDATE designconsultationrequest SET statusID=2 WHERE id = $row_id";
    if(mysqli_query($connection, $upQuery)){
        echo "success";
        }
    exit();
}

    }



?>