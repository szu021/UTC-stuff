<?php
require_once '../assets/admin_common.php';   // brings in the shared functions
require_once '../assets/dbconn.php';   // brings in the database connection

// this only runs when the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try { // try to add the game
        if (reg_game(dbconnect_insert())) { // connect to the database then add the game
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

// get the lists of developers and publishers so the drop down boxes have something in them
try {
    $developers = get_developers(dbconnect_insert()); // connect to the database then get the developers
    $publishers = get_publishers(dbconnect_insert()); // connect again then get the publishers
} catch (PDOException $e) { // catches database errors
    echo $e->getMessage(); // shows the error
    exit; // stops the page
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Game</title>
</head>
<body>

<h1>Add a Game</h1>

<!-- the form sends its data back to this same page using post -->
<form action="" method="post">
    <!-- the name of the game -->
    <label for="name">Game Name:</label><br>
    <input type="text" id="name" name="name" required><br><br>

    <!-- drop down box for picking the developer -->
    <label for="developer_id">Developer:</label><br>
    <select id="developer_id" name="developer_id" required>
        <option value="">Select a Developer</option>
        <?php
        // go through every developer one at a time
        foreach ($developers as $d) {
            // make an option for it, the value is the id and the text is the name
            echo "<option value='" . $d['developer_id'] . "'>" . $d['name'] . "</option>";
        }
        ?>
    </select><br><br>

    <!-- drop down box for picking the publisher -->
    <label for="publisher_id">Publisher:</label><br>
    <select id="publisher_id" name="publisher_id" required>
        <option value="">Select a Publisher</option>
        <?php
        // go through every publisher one at a time
        foreach ($publishers as $p) {
            // make an option for it, the value is the id and the text is the name
            echo "<option value='" . $p['publisher_id'] . "'>" . $p['name'] . "</option>";
        }
        ?>
    </select><br><br>

    <!-- the button that sends the form -->
    <input type="submit" value="submit">
</form>

</body>
</html>