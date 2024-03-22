<?php
session_start();
$connection = mysqli_connect("localhost", "root", "root", "webdb");

if (isset($_GET['projectId'])) {
    $projectId = $_GET['projectId'];
    $deleteQuery = "DELETE FROM designportoflioproject WHERE id = $projectId";
    
    if (mysqli_query($connection, $deleteQuery)) {
        echo '<script>alert("Project deleted successfully.");</script>';
        echo '<script>window.location = "designerHomePage.php";</script>';
    } else {
        echo '<script>alert("Error deleting project.");</script>';
    }
} else {
    echo '<script>alert("Project ID not found in URL.");</script>';
}
?>
