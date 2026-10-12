<?php
require_once '../assets/admin_common.php';   // brings in the shared functions
require_once '../assets/dbconn.php';   // brings in the database connection

// this only runs when the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try { // try to add the publisher
        if (reg_pub(dbconnect_insert())) { // connect to the database then add the publisher
            header("Location: index.php"); // if it worked go to the index page
            exit; // stop the rest of the page from running
        }
    } catch (PDOException $e) { // catches database errors
        echo $e->getMessage(); // shows the error
        exit; // stops the page
    } catch (Exception $e) { // catches any other errors
        echo $e->getMessage(); // shows the error
        exit; // stops the page
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Publisher</title>
</head>
<body>

<h1>Add a Publisher</h1>

<!-- the form sends its data back to this same page using post -->
<form action="" method="post">
    <!-- the name of the publisher -->
    <label for="name">Publisher Name:</label><br>
    <input type="text" id="name" name="name" required><br><br>

    <!-- where the publisher is based -->
    <label for="location">Location of publisher:</label><br>
    <input type="text" id="location" name="location" required><br><br>

    <!-- the button that sends the form -->
    <input type="submit" value="submit">
</form>

</body>
</html>