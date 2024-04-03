<?php
    session_start();

    $connection = mysqli_connect("localhost", "root", "root", "webdb");
    $error = mysqli_connect_error();
    if ($error != null) {
        echo json_encode(['error' => 'Cannot connect to DB']);
    } else {
        if (!isset($_SESSION['userID'])) {
            echo json_encode(['error' => 'You are not logged in, please login or sign up first']);
            exit();
        }

        if (!isset($_SESSION['userType']) || $_SESSION['userType'] == "designer") {
            echo json_encode(['error' => 'You do not have access to this page']);
            exit();
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['category']) && !empty($_POST['category'])) {
                $selected_category = $_POST['category'];

                $sql = "SELECT D.*, GROUP_CONCAT(DC.category) as specialties FROM Designer D 
                        INNER JOIN DesignerSpeciality DS ON D.id = DS.designerID 
                        INNER JOIN DesignCategory DC ON DS.designCategoryID = DC.id 
                        WHERE DC.category = ?
                        GROUP BY D.id";
                $stmt = $connection->prepare($sql);
                $stmt->bind_param("s", $selected_category);
                $stmt->execute();
                $result = $stmt->get_result();
                $designers = [];
                while ($row = mysqli_fetch_assoc($result)) {
                    // Fetch preferences for each designer
                    $sql2 = "SELECT DC.category FROM DesignerSpeciality DS
                            INNER JOIN DesignCategory DC ON DS.designCategoryID = DC.id
                            WHERE DS.designerID = ?";
                    $stmt2 = $connection->prepare($sql2);
                    $stmt2->bind_param("i", $row['id']);
                    $stmt2->execute();
                    $preferences = $stmt2->get_result();
                    $preferences_array = [];
                    while ($pref_row = mysqli_fetch_assoc($preferences)) {
                        $preferences_array[] = $pref_row['category'];
                    }
                    $stmt2->close();

                    $row['specialties'] = $preferences_array;
                    $designers[] = $row;
                }
                echo json_encode($designers);
            } else {
                echo json_encode(['error' => 'Category not provided']);
            }
        } else {
            echo json_encode(['error' => 'Invalid request']);
        }
    }
?>