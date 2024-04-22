<?php
session_start();
include 'databaseConnection.php';

if (isset($_POST['id'])) {
    $projectId = $_POST['id'];
    $deleteQuery = "DELETE FROM designportoflioproject WHERE id = $projectId";
    
    if (mysqli_query($connection, $deleteQuery)) {
        echo 1;
        exit();
    } else {
        echo 0;
        exit();
    }
} else {
    echo '<script>alert("Project ID not found in URL.");</script>';
}
?>
