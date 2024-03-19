<?php
    session_start();

    $connection = mysqli_connect("localhost", "root", "root", "webdb");
    $error = mysqli_connect_error();
    if ($error != null) {
        echo '<p> cant connect to DB';
    } 
    else{


    if (!isset($_SESSION['userID'])) {
            echo("<script>alert('You are not logged in, please login or sign up first");
            echo("<script>window.location = 'index.php';</script>");
            exit();
    }
    
    if(!isset($_SESSION['userType']) || $_SESSION['userType']=="designer") {
        echo 'You do not have access to this page';
        echo("<script>window.location = 'designerHomePage.php';</script>"); //page doesnt exist yet
    }

  
    $clientID = $_SESSION['userID'];
    $sql = "SELECT id, firstName, lastName, emailAddress FROM Client WHERE id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $clientID);
    $stmt->execute();
    $stmt->bind_result($clientID, $firstName, $lastName, $emailAddress);
    $stmt->fetch();

    // Close statement
    $stmt->close();
    }

?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet"  href="clientHomepage.css?v=<?php echo time(); ?>">
        <link rel="stylesheet" href="basic.css?v=<?php echo time(); ?>">
        <script src="clientHomepage.js"></script>
        <title> <?php echo $firstName;?>'s Home page </title>
    </head>
    <body>
        <header id="topBar">
            <a href="clientHomepage.php"><img class="logo" src="images/lightBeigeLogo.png" alt="logo" ></a>
            <a id="logout" href="logout.php">Log-out</a>
        </header>
        
        <main>
            <div id="grid-home">
                <div id="textWrapper">
                    <p class="text">
                        <strong id="welcome">Welcome, <?php echo $firstName;?>!</strong><br><br>
                        We're thrilled to have you here as part of our design community.
                        Your journey into creating the perfect space begins now.
                        Let's transform your vision into reality together!
                    </p>
                </div>
            </div>
            <div class="info">
                <h1>Client information</h1>
                <div class="p">
                    <p><strong>First Name:</strong> <?php echo $firstName;?></p>
                    <p><strong>Last Name:</strong> <?php echo $lastName;?></p>
                    <p><strong>Email address:</strong> <?php echo $emailAddress;?></p>
                </div>
            </div>

            <div class="allDesigners">
                <h1>Designers</h1>
                <div class="filter">
                    <form action="clientHomepage.php" method="post">
                        <label for="category">Select Category:</label>
                        <select id="category">
                            <?php
                                $sql1= "SELECT category FROM DesignCategory";
                                if($results1 = mysqli_query($connection, $sql1)){
                                    while ($row = mysqli_fetch_assoc($results1)) {
                                        echo"<option name='".$row['category']."' value='".$row['category']."'>".$row['category']."</option>";
                                    }
                                }
                            ?>
                        </select>
                        <input id="filter" type="submit" value="Filter">
                    </form>
                </div>
                <div class="designers">
                        <?php
                            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                if(isset($_POST['category']) && !empty($_POST['category'])) {
                                    $selected_category = $_POST['category'];

                                    $sql = "SELECT D.* FROM Designer D INNER JOIN DesignerSpeciality DS"
                                            . " ON D.id = DS.designerID INNER JOIN DesignCategory DC ON DS.designCategoryID = DC.id"
                                            . " WHERE DC.category = ?";
                                    $stmt = $connection->prepare($sql);
                                    $stmt->bind_param("s", $selected_category);
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                }
                            } 
                            else{
                                $sql = "SELECT * FROM Designer";
                                $results = mysqli_query($connection, $sql);
                            }
                            
                            while ($row = mysqli_fetch_assoc($results)) {
                                echo'<div class="designer">';
                                echo'<div class="slider-container">';
                                echo'<div class="slider-wrapper">';
                                echo'<img src="images/'.$row['logoImgFileName'].'">';
                                echo'</div>';
                                echo'</div>';
                                echo'<a href="portfolio.php?designerID='.$row["id"].'&clientID='.$clientID.'"><img src="images/'.$row["logoImgFileName"].'" alt="logo" class="profile-pic"></a>';
                                echo'<a href="portfolio.php?designerID='.$row["id"].'&clientID='.$clientID.'"><h2>'.$row['brandName'].'</h2></a>';
                                echo'<p class="specialty"><strong>Design preference:</strong>';
                                $sql2="SELECT DC.category FROM DesignerSpeciality DS"
                                        . " INNER JOIN DesignCategory DC ON DS.designCategoryID = DC.id"
                                        . " WHERE DS.designerID = your_designer_id";
                                if($results2 = mysqli_query($connection, $sql2)){
                                    while($row2 = mysqli_fetch_assoc($results2)){
                                        echo'<span class="preference">'.$row2.'</span>';
                                    }
                                }
                                echo'</p>';
                                echo'<a href="requestConsultation.php?designerID='.$row["id"].'" class="consult">Request Design Consultation</a>';
                                echo'</div>';
                            } 
                        ?>
                </div>
            </div>

            <div class="PreviousDesign">
                <table border="1">
                    <caption>Previous Design Consultation Requests</caption>
                    <thead>
                      <tr>
                        <th>Designer</th>
                        <th>Room</th>
                        <th>Dimensions</th>
                        <th>Design Category</th>
                        <th>Color Preferences</th>
                        <th>Request Date</th>
                        <th>Design Consultation</th>
                      </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td><a href="portfolio.html"><img src="images/OIG.jpg" alt="logo" ></a><br/><a href="portfolio.html">Elevate Interiors</a></td>
                            <td>Living Room</td>
                            <td>4x5m</td>
                            <td>Modern</td>
                            <td>Beige and Green</td>
                            <td>4/1/2024</td>
                            <th>Pending Consultation</th>
                        </tr>
                        <?php
                            $sql3 = "SELECT DS.id, DS.logoImgFileName ,DS.brandName ,RT.type ,DCR.roomWidth ,DCR.roomLength ,DC.category ,"
                                    . "DCR.colorPreferences ,DCR.date ,RS.status ,DCn.consultation ,DCn.consultationImgFileName"
                                    . "FROM DesignConsultationRequest DCR INNER JOIN Designer DS ON DCR.designerID = DS.id "
                                    . "INNER JOIN DesignCategory DC ON DCR.designCategoryID = DC.id INNER JOIN LEFT JOIN "
                                    . "DesignConsultation DCn  ON DCR.id = DC.requestID INNER JOIN RequestStatus RS ON DCR.statusID = RS.id "
                                    . "WHERE DCR.clientID =".$clientID;
                            
                            if($results3 = mysqli_query($connection, $sql3)){
                                while ($row = mysqli_fetch_assoc($results3)) {
                                    echo"<tr>";
                                    echo'<td><a href="portfolio.php?designerID='.$row["id"].'&clientID='.$clientID.'"><img src="images/'.$row["logoImgFileName"].'" alt="logo"></a><br/><a href="portfolio.php?designerID='.$row["id"].'&clientID='.$clientID.'">'.$row['brandName'].'</a></td>';
                                    echo'<td>'.$row["type"].'</td>';
                                    echo'<td>'.$row["roomWidth"].'x'.$row["roomLength"].'m</td>';
                                    echo'<td>'.$row["category"].'</td>';
                                    echo'<td>'.$row["colorPreferences"].'</td>';
                                    echo'<td>'.$row["date"].'</td>';
                                    if($row["status"] == "pending consultation" || $row["status"] == "consultation declined"){
                                        echo'<td>'.$row["status"].'</td>';
                                    }
                                    else{
                                        echo'<th>'.$row["consultation"].'<br> <img src="images/'.$row["consultationImgFileName"].'" class="conseltationImg" alt="conseltation image" ></th>';
                                    }
                                    echo"</tr>";
                                }
                            }
                            
                        ?>
                    </tbody> 
                </table>
            </div>


            <div id="happy">
                <h1>OUR HAPPINESS GUARANTEE</h1>
                <p>If you’re not happy, we’re not happy. We know designing your home can be an intimidating experience, if you’re not happy with your design for whatever reason, let us know, and we’ll make it right.</p>
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