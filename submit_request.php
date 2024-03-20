<?php
session_start();

// Establish a database connection
$connection = mysqli_connect("localhost", "root", "root", "webdb");
$error = mysqli_connect_error();

if ($error != null) {
    echo '<p>Can\'t connect to DB';
} else {
    echo '<p>Connected to DB';

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve form data
        $room_type = $_POST["room-type"];
        $height = $_POST["height"];
        $width = $_POST["width"];
        $design_category = $_POST["design-category"];
        $color_preference = $_POST["colorPreference"];
        $designer_id = $_POST["designerId"];

        // Retrieve the client ID from the session
        $client_id = $_SESSION['userID'];
        $date = date('Y-m-d'); // Correct date format

        // Insert the request into the database with a pending status
        $sql = "INSERT INTO designconsultationrequest (roomTypeID, roomLength, roomWidth, designCategoryID, colorPreferences, clientID, designerID, statusID, date)
                VALUES ('$room_type', '$height', '$width', '$design_category', '$color_preference', '$client_id', '$designer_id', '1', '$date')";

        if (mysqli_query($connection, $sql)) {
            header("Location: clientHomepage.php");
            exit(); // Make sure to exit after redirection
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($connection);
        }
    } else {
        echo "Invalid request";
    }
}
?>
