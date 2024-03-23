<?php
    $connection = mysqli_connect("localhost", "root", "root", "webdb");
    $error = mysqli_connect_error();
    if ($error != null) {
        echo '<p> cant connect to DB';
    } else {
        echo '<p> connect to DB';
    }

    if (isset($_GET['designerID'])) {
        $designerID = $_GET['designerID'];

        $designer_query = "SELECT * FROM Designer WHERE id = ?";
        $designer_statement = mysqli_prepare($connection, $designer_query);
        mysqli_stmt_bind_param($designer_statement, 'i', $designerID);
        mysqli_stmt_execute($designer_statement);
        $designer_result = mysqli_stmt_get_result($designer_statement);

        if ($designer_result->num_rows > 0) {
            $designer_data = mysqli_fetch_assoc($designer_result);
            $brand_name = $designer_data['brandName'];
            $logo_img_file_name = $designer_data['logoImgFileName'];
        } else {
            echo "Designer not found!";
        }
    }

    if (isset($_GET['clientID'])) {
        $clientID = $_GET['clientID'];

        $client_query = "SELECT * FROM Client WHERE id = ?";
        $client_statement = mysqli_prepare($connection, $client_query);
        mysqli_stmt_bind_param($client_statement, 'i', $clientID);
        mysqli_stmt_execute($client_statement);
        $client_result = mysqli_stmt_get_result($client_statement);

        if ($client_result->num_rows > 0) {
            $client_data = mysqli_fetch_assoc($client_result);
            $client_name = $client_data['firstName'];
        } else {
            echo "Client not found!";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="portfolio.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="basic.css?v=<?php echo time(); ?>">
    <title><?php echo $brand_name; ?> portfolio</title>
</head>
<body>
<header id="topBar">
    <a href="clientHomepage.html"><img class="logo" src="images/lightBeigeLogo.png"></a>
    <a id="logout" href="index.html">Log-out</a>
</header>

<main>
    <div id="grid-home2">
        <div id="textWrapper">
            <p class="text">
                <strong id="welcome">Welcome <?php echo $client_name; ?> to <?php echo $brand_name; ?></strong><br>
                <img src="images/<?php echo $logo_img_file_name; ?>" alt="designer's logo" width="100" height="100"
                     style="border: solid"><br>
            </p>
        </div>
    </div>

    <?php
    if (isset($_GET['designerID'])) {
        $designerID = $_GET['designerID'];

        $designer_query = "SELECT * FROM Designer WHERE id = ?";
        $designer_statement = mysqli_prepare($connection, $designer_query);
        mysqli_stmt_bind_param($designer_statement, 'i', $designerID);
        mysqli_stmt_execute($designer_statement);
        $designer_result = mysqli_stmt_get_result($designer_statement);

        if ($designer_result->num_rows > 0) {
            while ($row = mysqli_fetch_assoc($designer_result)) {
                echo "<div class='info'>";
                echo "<h1>Designer information</h1>";
                echo "<img src='images/" . $row['logoImgFileName'] . "' alt='designer's logo'>";
                echo "<div class='p'>";
                echo "<p>First Name: " . $row['firstName'] . "</p>";
                echo "<p>Last Name: " . $row['lastName'] . "</p>";
                echo "<p>Email address: " . $row['emailAddress'] . "</p>";
                echo "<p>Brand Name: " . $row['brandName'] . "</p>";
                $brandName=$row['brandName'];
                $specialities_query = "SELECT DesignCategory.category FROM DesignerSpeciality INNER JOIN DesignCategory ON DesignerSpeciality.designCategoryID = DesignCategory.id WHERE designerID = ?";
                $specialities_statement = mysqli_prepare($connection, $specialities_query);
                mysqli_stmt_bind_param($specialities_statement, 'i', $designerID);
                mysqli_stmt_execute($specialities_statement);
                $specialities_result = mysqli_stmt_get_result($specialities_statement);
                if ($specialities_result->num_rows > 0) {
                    echo "<p><strong>Design preferences:</strong>";
                    while ($speciality_row = mysqli_fetch_assoc($specialities_result)) {
                        echo " <span class='preference'>" . $speciality_row['category'] . "</span>";
                    }
                    echo "</p>";
                }
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "Designer not found.";
        }
    }
    ?>
    <?php
    if (isset($_GET['designerID'])) {
        $designerID = $_GET['designerID'];

        $projects_query = "SELECT DesignPortoflioProject.projectName, DesignPortoflioProject.projectImgFileName, DesignPortoflioProject.description, DesignCategory.category FROM DesignPortoflioProject INNER JOIN DesignCategory ON DesignPortoflioProject.designCategoryID = DesignCategory.id WHERE designerID = ?";
        $projects_statement = mysqli_prepare($connection, $projects_query);
        mysqli_stmt_bind_param($projects_statement, 'i', $designerID);
        mysqli_stmt_execute($projects_statement);
        $projects_result = mysqli_stmt_get_result($projects_statement);

        if ($projects_result->num_rows > 0) {
            echo "<div class='allDesigns'>";
            echo "<h1>".$brandName." Projects</h1>";
            echo "<div class='designs'>";

            while ($row = mysqli_fetch_assoc($projects_result)) {
                echo "<div class='design'>";
                echo "<img src='images/" . $row['projectImgFileName'] . "'>";
                echo "<h2>" . $row['projectName'] . "</h2>";
                echo "<p class='specialty'><strong>Design category:</strong> " . $row['category'] . "</p>";
                echo "<p>" . $row['description'] . "</p>";
                echo "</div>";
            }
            echo "</div>";

            echo "<div id='consultcontainer'>";
            echo '<a href="requestConsultation.php?designerID='.$designerID.'" class="consult">Request Design Consultation</a>';
            echo "</div>";

            echo "</div>";
        } else {
            echo "No projects found for this designer.";
        }
    }
    ?>
</main>

<footer>
    <p>Contact Us |Phone: 0116753695 |Email: <a id="email" href="mailto:LuminousDesign@LuminousDesign.com">LuminousDesign@LuminousDesign.com</a></p>
    <p>Follow Us</p>
    <div class="social-media-icons">
        <a href=""><img src="images/x.png" alt="x icon"></a>
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