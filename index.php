<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="index.css?v=<?php echo time(); ?>">


        <title> Home page </title>
    </head>
    <body>
        <div class="wrapper fadeInDown">
            <!-- Icon -->
            <div class="fadeIn first">
                
            </div>
            <div id="formContent">
          
              <img src="images/lightBeigeLogo.png" id="icon" alt="User Icon" />


                <div class="fadeIn second">
                    Your place to find and create an incredible home
                </div>


                    <a href="logIn.html"  class="fadeIn third"> Log in </a>
          

                <div id="formFooter" >
                    Don't have an account? <a class="underlineHover" href="signUp.php">Sign up</a>
                </div>
          
            </div>
          </div>

        
                <?php
//            echo "<h1>hellow world</h1>";
//            echo "<br><p>from waref try try try</p>";
//            echo "<p>this echo from anathor divise</p>";
//            echo "<p>this echo from the first divise</p>";
//            echo "<p>this echo from anathor divise</p>";
//            echo "IT Woooooooooooooorked on Rana's device ;) ^^";
//            echo "shokraaannn wareeefffffff";
            
            $connection = mysqli_connect("localhost","root","root","webdb");
            $error = mysqli_connect_error();
            
            if($error != null){
                echo '<p> cant connect to DB';
                
            }
            else{
                 echo '<p> connect to DB';
            }
            
        ?>

        
    </body>
</html>