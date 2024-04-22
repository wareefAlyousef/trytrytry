<?php
session_start();
include 'databaseConnection.php';

if ($error != null) {
    echo '<p> cant connect to DB</p>';
} else {
    session_start();
    if (!isset($_SESSION['userID'])) {
            echo "<script>alert('You are not logged in, please login or sign up first');</script>";
            echo "<script>window.location = 'index.php';</script>";
            exit();
    }
    
    if(!isset($_SESSION['userType']) || $_SESSION['userType']=="client") {
        echo "<script> alert('You do not have access to this page');</script>";
        echo "<script>window.location = 'clientHomepage.php';</script>"; 
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['consultation'], $_POST['requestID'], $_FILES["image"])) {
        $consultation = mysqli_real_escape_string($connection, $_POST['consultation']);
        $requestID = mysqli_real_escape_string($connection, $_POST['requestID']);

        $statusIDQuery = "SELECT id FROM RequestStatus WHERE status = 'consultation provided'";
        $statusIDResult = mysqli_query($connection, $statusIDQuery);

        if ($statusIDResult && $statusRow = mysqli_fetch_assoc($statusIDResult)) {
            $statusID = $statusRow['id'];

            $updateQuery = "UPDATE DesignConsultationRequest SET statusID = $statusID WHERE id = $requestID";
            $results = mysqli_query($connection, $updateQuery);

            if ($results) {
                $temp_name = $_FILES['image']['tmp_name'];
                $extension = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
                $filenewname = $requestID . "." . $extension;
                $folder = "images/" . $filenewname;

                if (move_uploaded_file($temp_name, $folder)) {
                    $sql = "INSERT INTO designconsultation (requestID, consultation, consultationImgFileName) VALUES (?, ?, ?)";
                    $stmt = $connection->prepare($sql);
                    if ($stmt) {
                        $stmt->bind_param("sss", $requestID, $consultation, $filenewname);
                        $stmt->execute();
                        $stmt->close();
                        header("Location: designerHomePage.php");
                        exit();
                    } else {
                        echo "Error preparing statement: " . $connection->error;
                    }
                } else {
                    echo "Error moving uploaded file.";
                }
            } else {
                echo "Error updating status: " . mysqli_error($connection);
            }
        } else {
            echo "Status not found.";
        }
    }
}
?>