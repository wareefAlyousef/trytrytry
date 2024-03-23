<?php
session_start();
$connection = mysqli_connect("localhost", "root", "root", "webdb");
$error = mysqli_connect_error();
if ($error != null) {
    echo '<p> cant connect to DB</p>';
} else {
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