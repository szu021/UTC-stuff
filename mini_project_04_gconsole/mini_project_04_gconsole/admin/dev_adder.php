<?php
require_once '../assets/dbconn.php';   // brings in the database connection
require_once '../assets/admin_common.php';   // brings in the shared functions

// this only runs when the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try { // try to add the developer
        if (reg_developer(dbconnect_insert())) { // connect to the database then add the developer
            header("Location: ../index.php"); // if it worked go to the index page
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
<head> <!-- The head of the page, usually has the title, which is the tab's name as well as the link to the stylesheet to decorate the website. -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Developer</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<h1>Gconsole</h1>
<h1>developer adder</h1>

<!-- the form sends its data back to this same page using post -->
<form method="post" action="dev_adder.php">
    <div class="label_div">

        <!-- the name of the developer -->
        <label for="name"><strong>developer name:</strong></label>
        <input type="text" name="name" id="name" placeholder="name" required><br>

        <!-- where the developer is based -->
        <label for="location"><strong>location:</strong></label>
        <input type="text" name="location" id="location" placeholder="location" required><br>

        <!-- the button that sends the form -->
        <button type="submit">add developer</button>
    </div>

</form>

</body>
</html>
