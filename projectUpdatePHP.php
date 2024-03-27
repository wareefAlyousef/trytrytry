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
    }
    
        // Get project ID
        if (isset($_GET['projectId'])) {
            $id = $_GET['projectId'];
        }
            
        
        
        if(isset($_POST['submitButten1'])){

        $category = $_POST['category'];
        $categoryIDQuery = mysqli_query($connection, "SELECT id FROM designcategory WHERE category='$category'");
        $categoryIDAssoc = mysqli_fetch_assoc($categoryIDQuery);
        $categoryID = $categoryIDAssoc['id'];
                        
        // Generate unique filename for the uploaded image
        $path_parts = pathinfo($_FILES["image"]["name"]);
        $extension = $path_parts['extension'];
        $filenewname = $pName . "_" . uniqid() . "." . $extension;
        $folder = "images/" . $filenewname;
        
//        echo '<script>alert("'.$_POST['pName'].'-'.$filenewname.' '.-$categoryID.' - '.$_POST['description'].' - '.$id.'");</script>';                
        
        // Move uploaded file to the desired location
        if (move_uploaded_file($_FILES['image']['tmp_name'], $folder)) {
                echo '<script>alert("success to upload image.");</script>';                
        $up = "UPDATE designportoflioproject SET projectName='" . $_POST['pName'] . "', projectImgFileName='" . $filenewname . "', "
            . "designCategoryID='" . $categoryID . "', description='" . $_POST['description'] . "' WHERE id =" . $id;
                $plsWork = mysqli_query($connection, $up);
        if($plsWork){
                echo '<script>alert("project was updated successfully.");</script>';                
                echo '<script>window.location = "designerHomePage.php";</script>';
        }
        } else {
            echo '<script>alert("Failed to upload image.");</script>';
        }
        }//if
    
?>
