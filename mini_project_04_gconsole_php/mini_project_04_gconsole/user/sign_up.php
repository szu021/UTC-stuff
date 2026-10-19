<?php
session_start(); // sessions are needed to show messages and keep the user logged in
require_once "../assets/dbconn.php";
require_once "../assets/user_common.php";

try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (isset($_SESSION["user_id"])) { // already logged in so no need to sign up
            $_SESSION["usermessage"] = "You are already logged in.";
            header("Location: dashboard.php");
            exit;
        }
        elseif (strlen($_POST["password"]) < 8) { // server side check as html can be bypassed
            $_SESSION["usermessage"] = "Password must be at least 8 characters.";
            header("Location: sign_up.php");
            exit;
        }
        elseif (!onlyuser(dbconnect_insert(), $_POST["email"])) { // email already used
            $_SESSION["usermessage"] = "An account with that email already exists.";
            header("Location: sign_up.php");
            exit;
        }
        else {
            reg_user(dbconnect_insert());
            $_SESSION["usermessage"] = "Account created, you can now sign in.";
            header("Location: sign_in.php");
            exit;
        }
    }
} catch (PDOException $e) {
    $_SESSION["usermessage"] = $e->getMessage(); // TEMPORARY - shows the real error while developing
    error_log($e->getMessage());
    header("Location: sign_up.php");
    exit;
}
?>

<html>

<head>
    <title>sign up</title>
    <link rel="stylesheet" href="../assets/styles.css">
</head>

<body>
<div class="register_bar">
    <img id="image-preview" src="../assets/images/gconsole_light.png" alt="Gconsole logo">
    <h1>welcome</h1>
    <p>sign up to Gconsole to continue</p>
    <?php if (isset($_SESSION["usermessage"])) { echo '<p class="message">' . e(user_message()) . '</p>'; } ?>
    <form method="post" action=""> <!-- make a form for users to input information-->

        <input type="email" name="email" id="email" placeholder="Email" required>

        <input type="password" name="password" id="Password" placeholder="Password (8+ characters)" minlength="8" required>

        <input type='submit' name='sign up' value='sign up' />
    </form>
    <p><a href="sign_in.php">already have an account?</a></p>
</div>
</body>
</html>
