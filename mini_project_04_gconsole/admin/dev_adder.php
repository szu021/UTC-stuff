<?php
require_once '../assets/dbconn.php';   // brings in the database connection

// this only runs when the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try { // try to add the developer
        if (reg_dev(dbconnect_insert())) { // connect to the datab47ase then add the developer
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

<head>

    <title>Add Developer</title>
</head>
<body>

<h1>Add a Developer</h1>

<form action="" method="post">
    <label for="name">Developer Name:</label><br>
    <input type="text" id="name" name="name" required><br><br>

    <label for="location">Location of developer:</label><br>
    <input type="text" id="location" name="location" required><br><br>

    <input type="submit" value="submit">
</form>

</body>
</html>