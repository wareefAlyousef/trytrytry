<?php
    session_start();

    include 'databaseConnection.php';

    if ($error != null) {
        echo '<p> cant connect to DB';
    } 
    else{


    if (!isset($_SESSION['userID'])) {
            echo "<script>alert('You are not logged in, please login or sign up first');</script>";
            echo "<script>window.location = 'index.php';</script>";
            exit();
    }
    
    if(!isset($_SESSION['userType']) || $_SESSION['userType']=="designer") {
        echo "<script> alert('You do not have access to this page');</script>";
        echo "<script>window.location = 'designerHomepage.php';</script>"; 
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
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>
            function filterDesigners(category) {
                $.ajax({
                    type: 'POST',
                    url: 'filter_designers.php',
                    data: { category: category },
                    dataType: 'json',
                    success: function(response) {
                        if (response.error) {
                            alert(response.error);
                        } else {
                            updateDesigners(response);
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Error: ' + error);
                    }
                });
            }

            function updateDesigners(designers) {
                var html = '';
                designers.forEach(function(designer) {
                    html += '<div class="designer">';
                    html += '<a href="portfolio.php?designerID=' + designer.id + '&clientID=<?php echo $clientID; ?>"><img src="images/' + designer.logoImgFileName + '" alt="logo" class="profile-pic"></a>';
                    html += '<a href="portfolio.php?designerID=' + designer.id + '&clientID=<?php echo $clientID; ?>"><h2>' + designer.brandName + '</h2></a>';
                    html += '<p class="specialty"><strong>Design preference:</strong>';
                    designer.specialties.forEach(function(specialty) {
                        html += '<span class="preference">' + specialty + '</span>, ';
                    });
                    html = html.slice(0, -2); // Remove the last comma and space
                    html += '</p>';
                    html += '<a href="requestConsultation.php?designerID=' + designer.id + '" class="consult">Request Design Consultation</a>';
                    html += '</div>';
                });
                $('.designers').html(html);
            }
        </script>
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
                    <!-- <form action="clientHomepage.php" method="post"  > -->
                        <label for="category">Select Category:</label>
                        <select id="category" name="category" onchange="filterDesigners(this.value)">
                            <?php
                                $sql1 = "SELECT category FROM DesignCategory";
                                if ($results1 = mysqli_query($connection, $sql1)) {
                                    while ($row = mysqli_fetch_assoc($results1)) {
                                        echo "<option value='".$row['category']."'>".$row['category']."</option>";
                                    }
                                }
                            ?>
                        </select>
                        <!-- <input id="filter" type="submit" name="submit" value="Filter"> -->
                    <!-- </form> -->
                </div>
                <div class="designers">
                        <?php
                            /*if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                if (isset($_POST['category']) && !empty($_POST['category'])) {
                                    $selected_category = $_POST['category'];

                                    $sql = "SELECT D.* FROM Designer D INNER JOIN DesignerSpeciality DS"
                                            . " ON D.id = DS.designerID INNER JOIN DesignCategory DC ON"
                                            . " DS.designCategoryID = DC.id WHERE DC.category = ?";
                                    $stmt = $connection->prepare($sql);
                                    $stmt->bind_param("s", $selected_category);
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                    $stmt->close();
                                }
                            } else {*/
                                $sql = "SELECT * FROM Designer";
                                $result = mysqli_query($connection, $sql);
                            //}
                            
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo'<div class="designer">';
                                echo'<a href="portfolio.php?designerID='.$row["id"].'&clientID='.$clientID.'"><img src="images/'.$row["logoImgFileName"].'" alt="logo" class="profile-pic"></a>';
                                echo'<a href="portfolio.php?designerID='.$row["id"].'&clientID='.$clientID.'"><h2>'.$row['brandName'].'</h2></a>';
                                echo'<p class="specialty"><strong>Design preference:</strong>';
                                $sql2="SELECT DC.category FROM DesignerSpeciality DS"
                                        . " INNER JOIN DesignCategory DC ON DS.designCategoryID = DC.id"
                                        . " WHERE DS.designerID = ".$row["id"];
                                if($results2 = mysqli_query($connection, $sql2)){
                                    while($row2 = mysqli_fetch_assoc($results2)){
                                        echo'<span class="preference">'.$row2["category"].'</span>';
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
                        <?php
                            $sql3 = "SELECT DS.id as designerID, DS.logoImgFileName, DS.brandName, RT.type, DCR.roomWidth, DCR.roomLength, DC.category, DCR.colorPreferences, DCR.date, RS.status, DCn.consultation, DCn.consultationImgFileName
                                FROM DesignConsultationRequest DCR
                                INNER JOIN Designer DS ON DCR.designerID = DS.id
                                INNER JOIN DesignCategory DC ON DCR.designCategoryID = DC.id
                                LEFT JOIN DesignConsultation DCn ON DCR.id = DCn.requestID
                                INNER JOIN RequestStatus RS ON DCR.statusID = RS.id
                                INNER JOIN RoomType RT ON DCR.roomTypeID = RT.id
                                WHERE DCR.clientID = ?";

                            if ($stmt = mysqli_prepare($connection, $sql3)) {
                                mysqli_stmt_bind_param($stmt, "i", $clientID);
                                mysqli_stmt_execute($stmt);
                                $results3 = mysqli_stmt_get_result($stmt);

                                while ($row = mysqli_fetch_assoc($results3)) {
                                    echo "<tr>";
                                    echo '<td><a href="portfolio.php?designerID='.$row["designerID"].'&clientID='.$clientID.'"><img src="images/'.$row["logoImgFileName"].'" alt="logo"></a><br/><a href="portfolio.php?designerID='.$row["designerID"].'&clientID='.$clientID.'">'.$row['brandName'].'</a></td>';
                                    echo '<td>'.$row["type"].'</td>';
                                    echo '<td>'.$row["roomWidth"].'x'.$row["roomLength"].'m</td>';
                                    echo '<td>'.$row["category"].'</td>';
                                    echo '<td>'.$row["colorPreferences"].'</td>';
                                    echo '<td>'.$row["date"].'</td>';
                                    if ($row["status"] == "consultation provided") {
                                        echo '<th>'.$row["consultation"];
                                        echo '<br> <img src="images/'.$row["consultationImgFileName"].'" class="conseltationImg" alt="consultation image" width = "200px" ></th>';
                                    } else {
                                        echo '<th>'.$row["status"].'</th>';
                                    }
                                    echo "</tr>";
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