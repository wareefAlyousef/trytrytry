
<?php
    if (!isset($_SESSION['userID'])) {
            echo "<script>alert('You are not logged in, please login or sign up first');</script>";
            echo "<script>window.location = 'index.php';</script>";
            exit();
    }
    
    if(!isset($_SESSION['userType']) || $_SESSION['userType']=="designer") {
        echo "<script> alert('You do not have access to this page');</script>";
        echo "<script>window.location = 'designerHomepage.php';</script>"; 
    }

// Get designer ID from query string
$designerId = isset($_GET['designerID']) ? (int)$_GET['designerID'] : null;

if (!$designerId) {
  // Handle error: missing designer ID
  echo "Error: Designer ID not provided.";
  exit;
}


?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="requestConsultation.css">
        <link rel="stylesheet" href="basic.css">
        <title>Request design consultation page </title>
    </head>
    <body>
        <header id="topBar">
            <a href="clientHomepage.html"><img class="logo" src="images/lightBeigeLogo.png" alt="logo" ></a>
            <a id="logout" href="index.html">Log-out</a>
        </header>
        
        <main>




            <div id="grid-home2">
                <div id="textWrapper">
                    <p class="text">
                        <strong id="welcome"> Request design consultation</strong>
                    </p>
                </div>
            </div>


            <div id="mainCONbody">
                
                <div class="info">
                    <h1>Request Consultation Form</h1>
                    <form action="submit_request.php" method="post" >

                        <label for="room-type">Room Type:</label> <br>
                        <select id="room-type" name="room-type">
                          <option value="1">Living Room</option>
                          <option value="2">Kitchen</option>
                          <option value="3">Dining Room</option>
                          <option value="4">Bedroom</option>
                        </select> <br> <br>


                        <label >Room Dimensions ( in meter):<br>
                            <label> height: <input type="text" name="height"><br></label>
                            <label> width: <input type="text" name="width"></label>


                        </label><br><br>

                        <label for="design-category">Design Category:</label> 
                        <select id="design-category" name="design-category">
                        <option value="4">Traditional</option>
                        <option value="3">Bohemian</option>
                        <option value="1">Country</option>
                        <option value="2">Modern</option>
                        </select> <br><br>


                        
                        <label >Color Preferences:<br>
                             <input type="text" name="colorPreference">
                           


                        </label><br><br>
                        
                        <input type="hidden" name="designerId" value="<?php echo $designerId; ?>">

                        
                    <div class="submit-container">
                        <input type='submit' value='Send' id="submitButten1">

                    </div>
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