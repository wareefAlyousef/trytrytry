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
    $sql = "SELECT id, firstName, lastName, emailAddress, brandName FROM designer WHERE id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $designerID);
    $stmt->execute();
    $stmt->bind_result($designerID, $firstName, $lastName, $emailAddress, $brandName);
    $stmt->fetch();
            //echo "<script>alert(".$designerID.");</script>";

    // Close statement
    $stmt->close();
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="basic.css?v=<?php echo time(); ?>">
        <link rel="stylesheet" href="designerHomePage.css?v=<?php echo time(); ?>">
        <script defer src="designerHomePage.js"></script>
        <title>Designer Homepage</title>
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
                        <strong id="welcome">welcome <?php echo $firstName;?> ! </strong>
                    </p>
                </div>
            </div>


            <h1>My Information</h1>
            <div class="info">
                <div class="p">
                    <p>First Name: <?php echo $firstName;?></p>
                    <p>Last Name: <?php echo $lastName;?></p>
                    <p>Email address: <?php echo $emailAddress;?></p>
                    <div class="brandLogo">
                        <p>Brand Name: <?php echo $brandName;?></p>
                        <p>Logo:</p>
                        <?php
                            $sqlimg= "SELECT logoImgFileName FROM designer WHERE id=$designerID";
                            if($resultsimg = mysqli_query($connection, $sqlimg)){
                                while ($rowimg = mysqli_fetch_assoc($resultsimg)) {
//                                    echo "<script>alert(".$rowimg["projectImgFileName"].");</script>";
                                    echo '<img src="images/'.$rowimg["logoImgFileName"].'" width="100" height="100" style="border: solid" >';

                                }
                            }
                        ?>
                    </div>
                    <p>Design Preference: 
                        <?php
                            $sql1= "SELECT category FROM DesignCategory WHERE id IN (SELECT designCategoryID FROM designerspeciality WHERE designerID = '$designerID')";
                            if($results1 = mysqli_query($connection, $sql1)){
                                while ($row = mysqli_fetch_assoc($results1)) {
                                    echo"<option name='".$row['category']."' value='".$row['category']."'>".$row['category']."</option>";
                                }
                            }
                        ?>
                    </p>
                </div>
            </div>




            <div class="allDesigns">
                <h1>Designs</h1>
                <a href="projectAddition.php" id="addProject">Add New Project</a>
                <div class="designs">
                    
                        <?php                        
                            $sql = "SELECT * FROM designportoflioproject WHERE designerID = '$designerID'";
                            $result = mysqli_query($connection, $sql);
                            
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo'<div class="design hidden">';
                                
                                    echo'<div class="slider-container"> <div class="slider-wrapper">';
                                        echo '<img src="images/'.$row["projectImgFileName"].'" style="height: 250px; width: 500px;" >';
//                                        echo '<img src="images/'.$row["logoImgFileName"].'" alt="logo" class="profile-pic">';
                                    echo'</div></div>';
                                
                                    echo '<h2>'.$row["projectName"].'</h2>';
                                    echo '<p>'.$row['description'].'</p>';
                                    $sql2= 'SELECT category FROM DesignCategory WHERE id IN (SELECT designCategoryID FROM designportoflioproject WHERE projectName = "'.$row["projectName"].'")';
                                    
                                    if($results2 = mysqli_query($connection, $sql2)){
                                        echo '<p class="specialty"><strong>Design preference: </strong>';
                                        while ($row2 = mysqli_fetch_assoc($results2)) {
                                            echo '<span class="preference">'.$row2['category'].' </span>';
                                        }
                                            echo '</p>';
                                    }
//                                    
                                    echo'<a href="projectUpdate.php?projectId='.$row["id"].'" class="consult" name="'.$row["projectName"].'" id="'.$row["projectName"].'">Edit</a>';
                                    echo '<a href="deleteProject.php?projectId='.$row["id"].'" name = "deleteProject" class="consult">Delete</a>';
                                echo'</div>';
                            } 
                        ?>
                    
<!--                    

                    <div class="design hidden">
                        <div class="slider-container">
                            <div class="slider-wrapper">
                                <img src="images/3.jpg" style="height: 250px; width: 500px;">
                            </div>
                        </div>
                        <h2>Modern Boho</h2>
                        <p class="specialty"><strong>Design preference:</strong> <span class="preference">Traditional</span> <span class="preference">Bohemian</span></p>
                        <p>A modern and cozy living room with a touch of bohemian style, featuring large windows, wooden accents, and a green abstract painting.</p>
                        <a href="projectUpdate.html" class="consult">Edit</a>
                        <a href="request-consultation.html" class="consult">Delete</a>
                    </div>

                    <div class="design hidden">
                        <div class="slider-container">
                            <div class="slider-wrapper">
                                <img src="images/4.jpg" style="height: 250px; width: 500px;">
                            </div>
                        </div>
                        <h2>Wooden Charm</h2>
                        <p  class="specialty"><strong>Design preference:</strong> <span class="preference">Traditional</span> <span class="preference">Country</span></p>
                        <p>A well-lit, elegant kitchen interior with white cabinetry, marble countertop, and wooden accents.</p>
                        <a href="projectUpdate.html" class="consult">Edit</a>
                        <a href="request-consultation.html" class="consult">Delete</a>
                    </div>

                    <div class="design hidden">
                        <div class="slider-container">
                            <div class="slider-wrapper">
                                <img src="images/c4.jpg" style="height: 250px; width: 500px;">
                            </div>
                        </div>
                        <h2>Bright Oasis</h2>
                        <p class="specialty"><strong>Design preference:</strong> <span class="preference">Traditional</span> <span class="preference">Country</span></p>
                        <p>A cozy and bright living area with a mix of modern and bohemian elements, featuring large windows, wooden accents, and abstract art.</p>
                        <a href="projectUpdate.php" class="consult">Edit</a>
                        <a href="request-consultation.html" class="consult">Delete</a>
                    </div>
                    
                </div>
            </div>-->
<?php echo'</div></div>';?>




            <div class="requestsTable" >
                <h1 style="font-size: 1.5em;">Design Consultation Requests</h1>
                <table border="1">
                    <!-- <caption>Design Consultation Requests</caption> -->
                    <thead>
                      <tr>
                        <th>Client</th>
                        <th>Room</th>
                        <th>Dimensions</th>
                        <th>Design Category</th>
                        <th>Color Preferences</th>
                        <th>Date</th>
                        <th colspan="2" style="background-color: #f1efed; border-color: #f1efed;"></th>
                      </tr>
                    </thead>

                    <tbody>
                        <?php
                            $sql3 = 'SELECT * FROM designconsultationrequest WHERE designerID = '.$designerID.' AND statusID=1';
                            if($results3 = mysqli_query($connection, $sql3)){
                                while ($row = mysqli_fetch_assoc($results3)) {
                                    $id = $row['id'];
                                    $cName = 'SELECT firstName AS f, lastName AS l FROM client WHERE id = '.$row['clientID'].'';
                                    $rType = 'SELECT type FROM roomtype WHERE id = '.$row['roomTypeID'].'';
                                    $dCategory = 'SELECT category FROM DesignCategory WHERE id= '.$row['designCategoryID'].'';

                                    mysqli_query($connection, $cName);
                                    mysqli_query($connection, $rType);
                                    mysqli_query($connection, $dCategory);
                                    
                                    echo"<tr>";
                                    
                                        if($resultsName = mysqli_query($connection, $cName)){
                                            while ($rowName = mysqli_fetch_assoc($resultsName)){
                                                echo'<td>'.$rowName['f'].' '.$rowName['l'].'</td>'; // client name
                                        }}
                                        if($resultsType = mysqli_query($connection, $rType)){
                                            while ($rowType = mysqli_fetch_assoc($resultsType)){
                                                echo'<td>'.$rowType["type"].'</td>'; // room type
                                        }}
                                        echo'<td>'.$row["roomWidth"].'x'.$row["roomLength"].'m</td>'; //done                                        
                                        if($resultsCate = mysqli_query($connection, $dCategory)){
                                            while ($rowCate = mysqli_fetch_assoc($resultsCate)){
                                                echo'<td>'.$rowCate["category"].'</td>'; // Design Category
                                        }}
                                        echo'<td>'.$row["colorPreferences"].'</td>'; //done
                                        echo'<td>'.$row["date"].'</td>';
                                        
                                        
                                        
                                        
                                        echo '<th><a class="provide-decline" href="designconsultation.php?requestID='.$id.'">Provide Consultation</a></th>';
                                        //$prov = 'UPDATE designconsultationrequest SET statusID=3 WHERE id='.$row['id'].'';
                                        echo '<th><a class="provide-decline" href="declineConsultation.php?requestID='.$id.'">Decline Consultation</a></th>';
//                                        echo '<th>';
//                                        echo '<form method="post">';
//                                        echo '<input type="hidden" name="request_id" value="' . $row['id'] . '">';
//                                        echo '<button type="submit" name="decline" class="provide-decline" style = "background-color: #4B4D43;   border: none; font-family: Amiri, serif; font-weight: bold; font-size: 16px;">Decline Consultation</button>';
//                                        echo '</form>';
//                                        echo '</th>';
                                        
                                    echo"</tr>";
                                }
                            }                            
                        ?>
                        
                        
<!--                        <tr>
                            <td>Dalal Aldugaither</td>
                            <td>Living Room</td>
                            <td>5x6m</td>
                            <td>Modern</td>
                            <td>Beige and Green</td>
                            <td>28/1/2024</td>
                            <th><a class="provide-decline" href="designConsultation.html">Provide Consultation</a></th>
                            <th><a class="provide-decline" href="">Decline Consultation</a></th>
                        </tr>

                            <tr>
                            <td>Reem Alshagran</td>
                            <td>Study Room</td>
                            <td>4x5m</td>
                            <td>Bohemian</td>
                            <td>Beige and Orange</td>
                            <td>9/1/2024</td>
                            <th><a class="provide-decline" href="designConsultation.html">Provide Consultation</a></th>
                            <th><a class="provide-decline" href="">Decline Consultation</a></th>
                        </tr>-->
                    </tbody> 
                </table>
            </div>



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