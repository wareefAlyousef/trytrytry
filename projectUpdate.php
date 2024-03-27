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
            
    
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="projectAddition.css">
        <link rel="stylesheet" href="basic.css">
        <title>update page </title>
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
                        <strong id="welcome"> Update project </strong>
                    </p>
                </div>
            </div>


            
            <div class="info">
                <h1>New Project</h1>
                <!--<form action="projectUpdate.php" method="post" enctype="multipart/form-data">-->
                <form action="projectUpdatePHP.php?projectId=<?php echo $id; ?>" method="post" enctype="multipart/form-data">
                    <?php
//                    retrieve project data
                        $sql = "SELECT * FROM designportoflioproject WHERE id=$id";
                        $result = mysqli_query($connection, $sql);

                        while ($row = mysqli_fetch_assoc($result)) {
                        $pName = $row['projectName'];
                        $pImg = $row["projectImgFileName"];
                        $description = $row['description'];
                        
                        $designCategoryID = $row['designCategoryID'];
                        $sqlcat='SELECT * FROM designcategory WHERE id='.$designCategoryID;
                        $resulcat= mysqli_query($connection, $sqlcat);
                        while($rowcat= mysqli_fetch_assoc($resulcat)){
                            $designCategory = $rowcat['category'];
                        }
                        }
                    ?>
                    
                    <div class="item">
                        <label for="name">Project Name:</label> <br>
                        <?php echo '<input type="text" id="pName" name="pName" value="'.$pName.'" placeholder="Enter your project\'s name" required>'; ?>
                    </div> <br>

            
                    <label for="image">Upload file:</label><br>
                    <?php echo '<img src="images/'.$pImg.'" style="height: 90px; width: 150px;" ><br>'; ?>
                    <input type='file' id='image' name='image'> <br><br>
                    

                    <div class="item">
                        <label for="name">Design Category:</label> <br>
                        <select name="category">
                            <?php
                                $sql='SELECT * FROM designcategory';
                                $result= mysqli_query($connection, $sql);
                                while($row= mysqli_fetch_assoc($result))
                                {
                                    if ($row['category'] == $designCategory)
                                    echo '<option selected name="'.$designCategory.'" value="'.$designCategory.'">'.$designCategory.'</option>';
                                    if ($row['category'] != $designCategory)
                                    echo '<option name="'.$row['category'].'" value="'.$row['category'].'">'.$row['category'].'</option>';
                                }
                            ?>
                          </select>
                        
                    </div> <br>

                    <div class="item">
                        <label for="description">Project Description:</label> <br>
                        <?php echo '<textarea id="description" name="description" placeholder="Enter your project\'s description" rows="8" cols="50">'.$description.'</textarea>'; ?>
                    </div> <br>
            
                    <input type='submit' value='Send' id="submitButten1" name="submitButten1">
                 </form> 
               
            </div>

        </div>                                    
        </main>
                
        <?php 
//        if(isset($_POST['submitButten1'])){
//
//        $category = $_POST['category'];
//        $categoryIDQuery = mysqli_query($connection, "SELECT id FROM designcategory WHERE category='$category'");
//        $categoryIDAssoc = mysqli_fetch_assoc($categoryIDQuery);
//        $categoryID = $categoryIDAssoc['id'];
//                        
//        // Generate unique filename for the uploaded image
//        $path_parts = pathinfo($_FILES["image"]["name"]);
//        $extension = $path_parts['extension'];
//        $filenewname = $pName . "_" . uniqid() . "." . $extension;
//        $folder = "images/" . $filenewname;
//        
////        echo '<script>alert("'.$_POST['pName'].'-'.$filenewname.' '.-$categoryID.' - '.$_POST['description'].' - '.$id.'");</script>';                
//        
//        // Move uploaded file to the desired location
//        if (move_uploaded_file($_FILES['image']['tmp_name'], $folder)) {
//                echo '<script>alert("success to upload image.");</script>';                
//        $up = "UPDATE designportoflioproject SET projectName='" . $_POST['pName'] . "', projectImgFileName='" . $filenewname . "', "
//            . "designCategoryID='" . $categoryID . "', description='" . $_POST['description'] . "' WHERE id =" . $id;
//                $plsWork = mysqli_query($connection, $up);
//        if($plsWork){
//                echo '<script>alert("project was updated successfully.");</script>';                
//                echo '<script>window.location = "designerHomePage.php";</script>';
//        }
//        } else {
//            echo '<script>alert("Failed to upload image.");</script>';
//        }
//        }//if
        ?>

        
        
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