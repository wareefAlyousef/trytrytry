<?php
session_start();
$connection = mysqli_connect("localhost", "root", "root", "webdb");

if(mysqli_connect_error()){
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();    
} 
    if (!isset($_SESSION['userID'])) {
            echo "<script>alert('You are not logged in, please login or sign up first');</script>";
            echo "<script>window.location = 'index.php';</script>";
            exit();
    }
    
    if(!isset($_SESSION['userType']) || $_SESSION['userType']=="client") {
        echo "<script> alert('You do not have access to this page');</script>";
        echo "<script>window.location = 'clientHomepage.php';</script>"; 
    }

if (isset($_GET['requestID'])) {
    $requestID = $_GET['requestID'];
    $upQuery = "UPDATE designconsultationrequest SET statusID=2 WHERE id = $requestID";
    //$prov = 'UPDATE designconsultationrequest SET statusID=3 WHERE id='.$row['id'].'';
    
    if (mysqli_query($connection, $upQuery)) {
        echo '<script>alert("The request was declined.");</script>';
        echo '<script>window.location = "designerHomePage.php";</script>';
    } else {
        echo '<script>alert("Error declining the request.");</script>';
    }
} else {
    echo '<script>alert("request ID not found in URL.");</script>';
}


?>