<?php
session_start();
require_once "assets/dbconn.php";
require_once "assets/user_common.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usr = login(dbconnect_insert(), $_POST["email_address"]);

    if ($usr && password_verify($_POST["password"], $usr["password"])) {
        $_SESSION["user_id"] = $usr["user_id"];
        header("Location: about.php");
        exit;
    } else {
        $_SESSION["usermessage"] = "Invalid email or password.";
        header("Location: login.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>

<body>
<img class="site_logo" src="assets/images/logo.png" alt="Diddly Squat Farm Shop">

<div class="register_bar">

    <h1>welcome</h1>
    <p>log in to Clarksons farm to continue</p>
    <?php if (isset($_SESSION["usermessage"])) { echo '<p class="message">' . e(user_message()) . '</p>'; } ?>
    <form method="post" action="">

        <input type="email" name="email_address" placeholder="email address" required>

        <input type="password" name="password" placeholder="Password" required>

        <input type="submit" name="login" value="login">
    </form>
    <p><a href="register.php">new here? sign up</a></p>
</div>
</body>
</html>
