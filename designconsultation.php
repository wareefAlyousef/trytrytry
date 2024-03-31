<?php
session_start();
    $connection = mysqli_connect("localhost", "root", "root", "webdb");
    $error = mysqli_connect_error();
    if ($error != null) {
        echo '<p> Can\'t connect to DB';
    } else {
                    if (!isset($_SESSION['userID'])) {
            echo "<script>alert('You are not logged in, please login or sign up first');</script>";
            echo "<script>window.location = 'index.php';</script>";
            exit();
    }
    
    if(!isset($_SESSION['userType']) || $_SESSION['userType']=="client") {
        echo "<script> alert('You do not have access to this page');</script>";
        echo "<script>window.location = 'clientHomepage.php';</script>"; 
    }
    

    if (isset($_GET['requestID'])) {
        $requestID = $_GET['requestID'];

        $request_query = "SELECT * FROM DesignConsultationRequest WHERE id =" . $requestID;
        if ($request_result = mysqli_query($connection, $request_query)) {
            $row = mysqli_fetch_assoc($request_result);
            $clientID = $row["clientID"];
            $roomTypeID = $row["roomTypeID"];
            $designCategoryID = $row["designCategoryID"];
            $roomWidth = $row["roomWidth"];
            $roomLength = $row["roomLength"];
            $colorPreferences = $row["colorPreferences"];
            $date = $row["date"];
            $statusID = $row["statusID"];
        }
    } else {
        echo "Designer not found!";
    }
    
    $name_query = "SELECT firstName, lastName FROM Client WHERE id =" . $clientID;
    if ($name_result = mysqli_query($connection, $name_query)) {
        $row1 = mysqli_fetch_assoc($name_result);
        $firstName = $row1['firstName'];
        $lastName = $row1['lastName'];
    }
    
    $type_query = "SELECT type FROM RoomType WHERE id =" . $roomTypeID;
    if ($type_result = mysqli_query($connection, $type_query)) {
        $row2 = mysqli_fetch_assoc($type_result);
        $type = $row2['type'];
    }
    
    $category_query = "SELECT category FROM DesignCategory WHERE id =" . $designCategoryID;
    if ($category_result = mysqli_query($connection, $category_query)) {
        $row3 = mysqli_fetch_assoc($category_result);
        $category = $row3['category'];
    } 
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="designConsultation.css?v=<?php echo time(); ?>">
        <link rel="stylesheet" href="basic.css?v=<?php echo time(); ?>">
        <title>Design Consultation page </title>
    </head>
    
    <body>
        <header id="topBar">
            <a href="designerHomePage.php"><img class="logo" alt="logo" src="images/lightBeigeLogo.png" ></a>
            <a id="logout" href="logout.php">Log-out</a>
        </header>
        
        <main>

            <div id="grid-home2">
                <div id="textWrapper">
                    <p class="text">
                        <strong id="welcome"> Design consultation</strong>
                    </p>
                </div>
            </div>



        <div id="mainCONbody">
            <div class="info">
                <h1>Request information</h1>
                <div class="p">
                    <p><strong>Client:</strong> <?php echo $firstName." ".$lastName; ?></p>
                    <p><strong>Room:</strong> <?php echo $type; ?></p>
                    <p><strong>Dimensions: </strong><?php echo $roomWidth."x".$roomLength."m"; ?></p>
                    <p><strong>Design Category:</strong> <?php echo $category; ?></p>
                    <p><strong>Color preference:</strong> <?php echo $colorPreferences; ?></p>
                    <p><strong>Date:</strong> <?php echo $date; ?></p>
                </div>
            </div>

            
            <div class="info">
                <h1> Consultation</h1>
                <form action="designConsultationForm.php" method="POST" enctype="multipart/form-data">
                    <label for="consultation">Consultation:</label><br>
                    <textarea id="consultation" name="consultation" rows="4" cols="50"></textarea><br><br>

                    <label for="image">Upload file:</label><br>
                    <input type="file" name="image" id="image" accept="image/*"><br><br>

                    <input type="hidden" name="requestID" value="<?php echo $requestID; ?>">
                    <input type="submit" name="submit" value="Send" id="submitButten1">
                </form> 
               
            </div>

        </div>

            
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