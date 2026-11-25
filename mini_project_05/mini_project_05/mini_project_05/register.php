<?php
session_start();
require_once "assets/dbconn.php";
require_once "assets/user_common.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = dbconnect_insert();

    if (!onlyuser($conn, $_POST["email"])) {
        $_SESSION["usermessage"] = "An account with that email already exists.";
        header("Location: register.php");
        exit;
    } else {
        $_SESSION["user_id"] = reg_user(dbconnect_insert());
        header("Location: about.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>register</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>

<body>
<img class="site_logo" src="assets/images/logo.png" alt="Diddly Squat Farm Shop">

<div class="register_bar">

    <h1>welcome</h1>
    <p>fill out all of the boxes to create an account</p>
    <?php if (isset($_SESSION["usermessage"])) { echo '<p class="message">' . e(user_message()) . '</p>'; } ?>
    <form method="post" action="">

        <input type="text" name="firstname" placeholder="First Name" required>

        <input type="text" name="surname" placeholder="Surname" required>

        <input type="tel" name="phone_number" placeholder="Phone Number" required>

        <input type="text" name="home_address" placeholder="Home address" required>

        <input type="email" name="email" placeholder="email address" required>

        <input type="password" name="password" placeholder="Password (8+ characters)" minlength="8" required>

        <input type="submit" name="register" value="Sign Up">
    </form>
    <p><a href="login.php">already have an account?</a></p>
</div>
</body>
</html>
