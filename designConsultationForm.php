<?php
    $connection = mysqli_connect("localhost","root","root","webdb"); 
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        $consultation = $_POST['consultation'];
        $requestID = $_POST['requestID'];

        $status = "consultation provided";
        $updateQuery = "UPDATE DesignConsultationRequest SET statusID = (SELECT id FROM RequestStatus WHERE status = ".$status.") WHERE id =".$requestID;
        $results = mysqli_query($connection, $updateQuery);
        
        if(isset($_FILES["image"])&& $_FILES["image"]["error"] == 0){
            //do image
            $temp_name = $_FILES['image']['tmp_name'];
            $path_parts = pathinfo($_FILES["image"]["name"]); //  to change file name
            $extension = $path_parts['extension']; //get extension
            $filenewname=$requestID.".".$extension; // newname.extension
            $folder = "images/".$filenewname; //create path to put image
            
            
            if (move_uploaded_file($temp_name, $folder)) {
            //finishes image
            $sql = "INSERT INTO DesignConsultation (requestID, consultation, consultationImgFileName) VALUES (".$requestID.", ".$consultation.", ".$filenewname.")";
            $results2 = mysqli_query($connection, $sql);

            header("Location: designerHomePage.php");
            exit();
            }
        }
    }    
?>