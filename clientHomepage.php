<?php

    $connection = mysqli_connect("localhost", "root", "root", "webdb");
    $error = mysqli_connect_error();
    if ($error != null) {
        echo '<p> cant connect to DB';
    } 
    else{
        echo '<p> connect to DB';
    }
    
    session_start();

    if (!isset($_SESSION['clientID'])) {
        echo "You are not logged in.";
        exit;
    }

  
    $clientID = $_SESSION['clientID'];
    $sql = "SELECT id, firstName, lastName, emailAddress FROM Client WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $clientID);
    $stmt->execute();
    $stmt->bind_result($clientID, $firstName, $lastName, $emailAddress);
    $stmt->fetch();

    // Close statement
    $stmt->close();

    // Display client information
    echo "Client ID: " . $clientID . "<br>";
    echo "First Name: " . $firstName . "<br>";
    echo "Last Name: " . $lastName . "<br>";
    echo "Email Address: " . $emailAddress . "<br>";

?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="clientHomepage.css">
        <link rel="stylesheet" href="basic.css">
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
                    <div class="designer">
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
                                echo"<p>".$row['id'].",".$row['firstName'].",".$row['lastName'].",".$row['emailAddress'].",".$row['brandName'].$row['logoImgFileName']."</p>";
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
                            } 
                        ?>
                    </div>
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

                        <tr>
                            <td><a href="portfolio.html"><img src="images/OIG (2).jpg" alt="logo"  ></a><br/><a href="portfolio.html">Artisan Interiors</a></td>
                            <td>Living Room</td>
                            <td>4x5m</td>
                            <td>Traditional</td>
                            <td>Beige and Green</td>
                            <td>6/1/2024</td>
                            <th> Create a modern and inviting living  space with a blend of beige and green elements, emphasizing comfort and style.<br> <img src="images/t1.jpg" class="conseltationImg" alt="conseltation image" ></th>
                        </tr>

                        <tr>
                            <td><a href="portfolio.html"><img src="images/OIG (3).jpg" alt="logo" ></a><br/><a href="portfolio.html">Nouveau Design</a></td>
                            <td>Living Room</td>
                            <td>4x5m</td>
                            <td>Country</td>
                            <td>Beige and Green</td>
                            <td>9/1/2024</td>
                            <th>Consultation Declined</th>
                        </tr>
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