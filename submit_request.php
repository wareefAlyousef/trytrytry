<?php
// Establish a database connection
  $connection = mysqli_connect("localhost","root","root","webdb");
            $error = mysqli_connect_error();
            
            if($error != null){
                echo '<p> cant connect to DB';
                
            }
            else{
                 echo '<p> connect to DB';
            


// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and retrieve form data
    $room_type = sanitize_input($_POST["room-type"]);
    $height = sanitize_input($_POST["height"]);
    $width = sanitize_input($_POST["width"]);
    $design_category = sanitize_input($_POST["design-category"]);
    $color_preference = sanitize_input($_POST["colorPreference"]);
    $designer_id = sanitize_input($_POST["designer_id"]); // Retrieve the designer ID from the hidden input field

    // Insert the request into the database with a pending status
    $sql = "INSERT INTO consultation_requests (room_type, height, width, design_category, color_preference, designer_id, status)
            VALUES ('$room_type', '$height', '$width', '$design_category', '$color_preference', '$designer_id', '1')";

    if ($conn->query($sql) === TRUE) {
        // Close the database connection
        $conn->close();

        // Redirect the user to the client's homepage
        header("Location: clientHomepage.php");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "Invalid request";
}

  }// end else

?>
