        <?php
    session_start();

    $connection = mysqli_connect("localhost", "root", "root", "webdb");
    $error = mysqli_connect_error();
    if ($error != null) {
        echo '<p> cant connect to DB<br>';
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

  
    $designerID = $_SESSION['userID'];
    }

    
    
    
    if (isset($_POST['submitButten1'])) {
        if (isset($_POST['name']) && isset($_POST['category']) && isset($_POST['description']) && isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
        $pName = $_POST['name'];
        $description = $_POST['description'];
        $category = $_POST['category'];

        // Prepare the query to insert data
        $queryCat = "SELECT id FROM designcategory WHERE category='$category'";
        $result = mysqli_query($connection, $queryCat);
        $row = mysqli_fetch_assoc($result);
        $categoryID = $row['id'];

        // Generate unique filename for the uploaded image
        $path_parts = pathinfo($_FILES["image"]["name"]);
        $extension = $path_parts['extension'];
        $filenewname = $pName . "_" . uniqid() . "." . $extension;
        $folder = "images/" . $filenewname;

        // Move uploaded file to the desired location
        if (move_uploaded_file($_FILES['image']['tmp_name'], $folder)) {
            // Insert data into database
            $sql = "INSERT INTO designportoflioproject (designerID, projectName, projectImgFileName, description, designCategoryID) VALUES (?, ?, ?, ?, ?)";
            $stmt = $connection->prepare($sql);
            $stmt->bind_param("isssi", $designerID, $pName, $filenewname, $description, $categoryID);
            if ($stmt->execute()) {
                echo '<script>alert("Project added successfully.");</script>';
                echo '<script>window.location = "designerHomePage.php";</script>';
                exit();
            } else {
                echo '<script>alert("Failed to add project.");</script>';
            }
        } else {
            echo '<script>alert("Failed to upload image.");</script>';
        }
    } else {
        echo '<script>alert("Failed to submit the form.");</script>';
    }
}
?>
