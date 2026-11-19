<?php
session_start();
require_once "dbconn.php";
require_once "user_common.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usr = login(dbconnect_insert(), $_POST["email_address"]);

    if ($usr && password_verify($_POST["password"], $usr["password"])) {
        $_SESSION["patient_id"] = $usr["patient_ID"];
        header("Location: home_page.php");
        exit;
    } else {
        $_SESSION["usermessage"] = "Invalid email or password.";
        header("Location: login.php");
        exit;
    }
}
?>

<html>

<head>
    <title>login</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>

<body>
<div class="register_bar">

    <h1>welcome</h1>
    <p>log in to continue</p>
    <?php if (isset($_SESSION["usermessage"])) { echo '<p class="message">' . e(user_message()) . '</p>'; } ?>
    <form method="post" action="">

        <input type="email" name="email_address" placeholder="Email" required>

        <input type="password" name="password" placeholder="Password" required>

        <input type="submit" name="login" value="login">
    </form>
    <p><a href="register.php">new here? register</a></p>
</div>
</body>
</html>
