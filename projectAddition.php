<?php
    session_start();

    $connection = mysqli_connect("localhost", "root", "root", "webdb");
    $error = mysqli_connect_error();
    if ($error != null) {
        echo '<p> cant connect to DB<br>';
    } 
    else{


    if (!isset($_SESSION['userID'])) {
            echo("<script>alert('You are not logged in, please login or sign up first");
            echo("<script>window.location = 'index.php';</script>");
            exit();
    }
    
    if(!isset($_SESSION['userType']) || $_SESSION['userType']=="client") {
        echo 'You do not have access to this page';
        echo("<script>window.location = 'clientHomepage.php';</script>"); //page doesnt exist yet
    }

  
    $designerID = $_SESSION['userID'];
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="projectAddition.css">
        <link rel="stylesheet" href="basic.css">
        <title>Design Consultation page </title>
    </head>
    <body>
        <header id="topBar">
            <a href="designerHomePage.php"><img class="logo" alt="logo" src="images/lightBeigeLogo.png" ></a>
            <a id="logout" href="index.php">Log-out</a>
        </header>
        
        <main>

            <div id="grid-home2">
                <div id="textWrapper">
                    <p class="text">
                        <strong id="welcome"> Add a new project </strong>
                    </p>
                </div>
            </div>


            
            <div class="info">
                <h1>New Project</h1>
                <form action="projectAdditionPHP.php" method="post" enctype="multipart/form-data">

                    <div class="item">
                        <label for="name">Project Name:</label> <br>
                        <input type="text" id="name" name="name" placeholder="Enter your project's name" required>
                    </div> <br>

            
                    <label for="image">Upload file:</label><br>
                    <input type='file' id='image' name='image'> <br><br>

                    <div class="item">
                        <label for="name">Design Category:</label> <br>
                        <select id="category" name="category">
                            <?php
                                $sql='SELECT * FROM designcategory';
                                $result= mysqli_query($connection, $sql);
                                while($row= mysqli_fetch_assoc($result))
                                {echo '<option name="'.$row['category'].'" value="'.$row['category'].'">'.$row['category'].'</option>';}
                            ?>
                          </select>
                    </div> <br>

                    <div class="item">
                        <label for="description">Project Description:</label> <br>
                        <textarea id="description" name="description"  placeholder="Enter a description for your project. Don't be afraid to get into details!" rows="8" cols="50" required></textarea>
                    </div> <br>
            
                    <input type='submit' value='Send' id="submitButten1" name="submitButten1">
                    
                 </form> 
               
            </div>

        </div>

        <?php
        
//        if (isset($_POST['submitButten1'])) {
//        if (isset($_POST['name']) && isset($_POST['category']) && isset($_POST['description']) && isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
//        $pName = $_POST['name'];
//        $description = $_POST['description'];
//        $category = $_POST['category'];
//
//        // Prepare the query to insert data
//        $queryCat = "SELECT id FROM designcategory WHERE category='$category'";
//        $result = mysqli_query($connection, $queryCat);
//        $row = mysqli_fetch_assoc($result);
//        $categoryID = $row['id'];
//
//        // Generate unique filename for the uploaded image
//        $path_parts = pathinfo($_FILES["image"]["name"]);
//        $extension = $path_parts['extension'];
//        $filenewname = $pName . "_" . uniqid() . "." . $extension;
//        $folder = "images/" . $filenewname;
//
//        // Move uploaded file to the desired location
//        if (move_uploaded_file($_FILES['image']['tmp_name'], $folder)) {
//            // Insert data into database
//            $sql = "INSERT INTO designportoflioproject (designerID, projectName, projectImgFileName, description, designCategoryID) VALUES (?, ?, ?, ?, ?)";
//            $stmt = $connection->prepare($sql);
//            $stmt->bind_param("isssi", $designerID, $pName, $filenewname, $description, $categoryID);
//            if ($stmt->execute()) {
//                echo '<script>alert("Project added successfully.");</script>';
//                echo '<script>window.location = "designerHomePage.php";</script>';
//                exit();
//            } else {
//                echo '<script>alert("Failed to add project.");</script>';
//            }
//        } else {
//            echo '<script>alert("Failed to upload image.");</script>';
//        }
//    } else {
//        echo '<script>alert("Failed to submit the form.");</script>';
//    }
//}
?>



            
        </main>

        <footer>
            <p>Contact Us |Phone: 0116753695  |Email: <a id="email" href="mailto:LuminousDesign@LuminousDesign.com">LuminousDesign@LuminousDesign.com</a></p>
            <p>Follow Us</p>
            <div class="social-media-icons">
                <a href=""><img src="images/x.png" alt="x icon" ></a>
                <a href=""><img src="images/f.png" alt="facebook icon"></a>                
                <a href=""><img src="images/insta.png" alt="instagram icon"></a>                
                <a href=""><img src="images/in.png" alt="linkedIn icon"></a>  
                <a href=""><img src="images/p.PNG" alt="pintrest icon"></a>
                <a href=""><img src="images/t.png" alt="tiktok icon"></a>          
            </div>
            <p>© 2024 Luminous Design, All Rights Reserved.</p>
        </footer>
        
    </body>
</html>