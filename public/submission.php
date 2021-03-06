<?php
require_once "../scripts/shared.php";
require_once "../scripts/menu.php";

$placenameError = $latitudeError = $longitudeError = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" and !empty($_POST)) {
    $photourl = "";
    if (file_exists($_FILES['newphoto']['tmp_name'])) {
        $photourl = uploadToS3($_FILES['newphoto']['tmp_name']);
    }
// If the place is successfully added to the database, redirect to the object's page.
    if (addPlace($_POST, $photourl)) {
        //header("Location: " . $redirect_page);
        //exit();
    }
}


// This function shows user a submission form if they are signed in.
// It shows the registration link otherwise.
function newObject() {
    global $placenameError, $latitudeError, $longitudeError;
    global $latitude, $longitude;
    if (isLoggedIn()) {
        echo '<form method="POST" action="submission.php" enctype="multipart/form-data">
            <label for="name">Name of Organization</label><br>
            <input id="name" name="placename" type="text" placeholder="Name of donation centre" value="' . rePOST("placename") . '"><br><br>
            <label for="description">Description</label><br>
            <input id="description" name="description" placeholder="Description" value="' . rePOST("description") . '"><br><br>
            <label for="address">Address</label><br>
            <input id="addess" name="address" placeholder="Address" value="' . rePOST("address") . '"><br><br>
            <label for="latitude">Latitude</label><br>
            <input id="latitude" name="latitude" type="number" step="0.001" placeholder="Latitude position" pattern="-[0-9]+\.[0-9]+" value="' . rePOST("latitude") . '"><br><br>
            <label for="longitude">Longitude</label><br>
            <input id="longitude" name="longitude" type="number" step="0.001" placeholder="Longitude position" pattern="-[0-9]+\.*[0-9]*" value="' . rePOST("longitude") . '"><br>
        <!-- This button gets the user location when clicked. -->
            <div class="buttonHolder">
                <button type="button" id="geolocation" onClick="getLocation()">Get my location</button>
            </div>
            <p id="status"></p>
            <legend>Accepts</legend>
            <fieldset>
                <input id="clothing" name="clothing" type="checkbox" value="clothing"><label for="clothing"> Clothing</label>
                <input id="electronics" name="electronics" type="checkbox" value="electronics"><label for="electronics"> Electronics</label>
                <input id="food" name="food" type="checkbox" value="food"><label for="food"> Food</label>
            </fieldset>
            <br>
            
            <div class="buttonHolder">
                <label for="image">Upload photo</label><br>
                <input id="image" type="file" name="newphoto"><br>
                <input id="submit" type="submit" value="Submit">
            </div>
        </form>';
    }
    else {
        echo "<p>You need an account to submit a donation centre. Register <a href='registration.php'>here</a>.</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
            show_title("Submit");
        ?>
        <link rel="stylesheet" href="css/style.css">
        <link rel="icon" href="images/logo.png">
        <script type ="text/javascript" src="../scripts/submission.js"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA10vc2deGv18oPyOA1w1k7H6i7mAIzMuA" type="text/javascript"></script>
    </head>
    <body>
        <div id="header-container">
<!-- The menu.php show_header function is used to generate the nav bar.
Passing the page title determines what the generated header looks like. -->
            <?php
                show_header("Submit");
            ?>
        </div>
        
        <div id="content-container">
            <div id="submission-content">
                <h3>Submit a donation centre location</h3>
                <div id="newobject">
                    <?php
                        newObject();
                    ?>
                </div>
            </div>
        </div>

        <div id="footer-container">
            <footer>
                Micaela Estabillo's CS 4WW3 Project
            </footer>
        </div>
    </body>
</html>