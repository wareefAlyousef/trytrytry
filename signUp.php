<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="signUp.css?v=<?php echo time(); ?>">
        <script src="signUp.js"></script>
        <title> Sign up </title>
    </head>
    <body>
        <div class="wrapper fadeInDown">
            <div id="formContent">
          
              <!-- Icon -->
                <div class="fadeIn first">
                  <a href="index.html">
                    <img src="images/lightBeigeLogo.png" id="icon" alt="User Icon" />
                    </a>
                </div>



                <div class="fadeIn second">
                      <fieldset>
          

                        <legend><h1>Sign up</h1></legend>
                        <div class="middle">
                            <h2>User type:</h2>
                            <label>
                              <input type="radio" name="type" value="designer"onclick="showdesigner()"/>
                              <div class="front-end box">
                                <span>Designer</span>
                              </div>
                            </label>
                          
                            <label>
                              <input type="radio" name="type" value="client" onclick="showclient()"/>
                              <div class="back-end box">
                                <span>Client</span>
                              </div>
                            </label>
                          </div>

                          <form action="clientSignup.php" method="POST" class="hide" id="cform">
                            <h2> Account info</h2> <br> 
                            <div class="input">
                              <input type="text" name="fname" id="fname" class="input-field" required/>
                              <label for="fname" class="input-label">First Name</label>
                          </div>

                          <div class="input">
                            <input type="text" name="lname" id="lname" class="input-field" required/>
                            <label for="lname" class="input-label">Last Name</label>
                        </div>

                        <div class="input">
                          <input type="email" name="email" id="email" class="input-field" required/>
                          <label for="email" class="input-label">Email</label>
                      </div>
  
                          <div class="input">
                              <input type="password" name="pass" id="pass" class="input-field" required/>
                              <label for="pass" class="input-label">Password</label>
                          </div>



                          <input type="submit" name="submit" class="fadeIn third" id="button" value="Sign up">

                          </form>



                          <form action="designerSignup.php" method="POST" class="hide" id="dform" enctype="multipart/form-data">
                            <h2> Account info</h2> <br> 
                            <div class="input">
                              <input type="text" name="fname" id="fname" class="input-field" required/>
                              <label for="fname" class="input-label">First Name</label>
                          </div>

                          <div class="input">
                            <input type="text" name="lname" id="lname" class="input-field" required/>
                            <label for="lname" class="input-label">Last Name</label>
                        </div>

                        <div class="input">
                          <input type="email" name="email" id="email" class="input-field" required/>
                          <label for="email" class="input-label">Email</label>
                      </div>
  
                          <div class="input">
                              <input type="password" name="pass" id="pass" class="input-field" required/>
                              <label for="pass" class="input-label">Password</label>
                          </div>

                          <h2> Brand info</h2> <br> 
                          <div class="input">
                            <input type="text" name="bname" id="bname" class="input-field" required/>
                            <label for="bname" class="input-label">Brand Name</label>
                        </div> 

                        <p>Brand Logo:</p>  

                        <div class="input">
                            <input type="file" name="logo" id="logo" accept="image/*">
                      </div>
                      <p>Speciality:</p> 
                      <div class="input" id="checks">
                          
                          <?php
                            $connection = mysqli_connect("localhost","root","root","webdb");   
                            $error = mysqli_connect_error();
                            if($error != null){
                            echo '<p> cant connect to DB';}             
                            else{ 
                                $sql='SELECT * FROM designcategory';
                                $result= mysqli_query($connection, $sql);
                                while($row= mysqli_fetch_assoc($result)){
                                    echo '<label class="pill">
                            <input type="checkbox" name="speciality[]" value="'.$row['id'].'" class="pill-checkbox"  />
                            <span class="pill-label">'.$row['category'].'</span>
                          </label>';
                                
                                    
                            } }

                                  ?>
                        
  

                  
                        </div>


                      <input type="submit" name="submit" class="fadeIn third" id="button" value="Sign up">

                          </form>
                          
                </div>


          

              <!-- Remind Passowrd -->
                <div id="formFooter">
                    Already have an account? <a class="underlineHover" href="logIn.html">Log in</a>
                </div>
          
            </div>
          </div>

        
    </body>
</html>


