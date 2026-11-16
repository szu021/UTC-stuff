<?php
session_start();
require_once "dbconn.php";
require_once "user_common.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = dbconnect_insert();

    if (!onlyuser($conn, $_POST["email_address"])) {
        $_SESSION["usermessage"] = "An account with that email already exists.";
        header("Location: register.php");
        exit;
    } else {
        $_SESSION["patient_id"] = reg_user(dbconnect_insert());
        header("Location: home_page.php");
        exit;
    }
}
?>

<html>

<head>
    <title>register</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>

<body>
<div class="register_bar">

    <h1>welcome</h1>
    <p>Create account for appointments</p>
    <?php if (isset($_SESSION["usermessage"])) { echo '<p class="message">' . e(user_message()) . '</p>'; } ?>
    <form method="post" action="">

        <input type="text" name="firstname" placeholder="First name" required>

        <input type="text" name="surname" placeholder="Surname" required>

        <input type="email" name="email_address" placeholder="Email" required>

        <input type="password" name="password" placeholder="Password (8+ characters)" minlength="8" required>

        <input type="text" name="home_address" placeholder="Home address" required>

        <input type="date" name="DOB" required>

        <input type="submit" name="register" value="register">
    </form>
    <p><a href="login.php">already have an account?</a></p>
</div>
</body>
</html>
