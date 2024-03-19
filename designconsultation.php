<?php
    $connection = mysqli_connect("localhost", "root", "root", "webdb");
    $error = mysqli_connect_error();
    if ($error != null) {
        echo '<p> cant connect to DB';
    } else {
        echo '<p> connect to DB';
    }

    if (isset($_GET['requestID'])) {
        $requestID = $_GET['requestID'];

        $request_query = "SELECT * FROM DesignConsultationRequest WHERE id =".$requestID;
        if($request_resul = mysqli_query($connection, $designer_query)){
            $row = mysqli_fetch_assoc($request_resul);
            $clientID = $row["$clientID"];
            $roomTypeID = $row["$roomTypeID"];
            $designCategoryID = $row["$designCategoryID"];
            $roomWidth = $row["$roomWidth"];
            $roomLength = $row["$roomLength"];
            $colorPreferences = $row["$colorPreferences"];
            $date = $row["$date"];
            $statusID= $row["$statusID"];
        }
    }    
    else {
        echo "Designer not found!";
    }
    
    $firstName=;
    $lastName= ;
    $type=;
    $category=;
    
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="designConsultation.css">
        <link rel="stylesheet" href="basic.css">
        <title>Design Consultation page </title>
    </head>
    
    <body>
        <header id="topBar">
            <a href="designerHomePage.html"><img class="logo" alt="logo" src="images/lightBeigeLogo.png" ></a>
            <a id="logout" href="index.html">Log-out</a>
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
                    <p><strong>Client:</strong> Sara Ahmad</p>
                    <p><strong>Room:</strong> living room</p>
                    <p><strong>Dimensions:</strong>4x5m</p>
                    <p><strong>Design Category:</strong> Modern</p>
                    <p><strong>Color preference:</strong> Beige and green</p>
                    <p><strong>Date:</strong> 9/1/2024</p>
                </div>
            </div>

            
            <div class="info">
                <h1> Consultation</h1>
                <form action="designerHomePage.html" method="post" >
                    <label for="consultation">Consultation:</label><br>
                    <textarea id="consultation" name="consultation" rows="4" cols="50"></textarea><br><br>
            
                    <label for="image">Upload file:</label><br>
                    <input type='file' id='image' name='image'><br><br>
            
                    <input type='submit' value='Send' id="submitButten1">
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