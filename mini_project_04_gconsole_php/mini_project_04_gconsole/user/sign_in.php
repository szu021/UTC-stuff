<?php
session_start(); // sessions are needed to remember who is logged in
require_once "../assets/dbconn.php";
require_once "../assets/user_common.php";

try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (isset($_SESSION["user_id"])) { // already logged in
            $_SESSION["usermessage"] = "You are already logged in.";
            header("Location: dashboard.php");
            exit;
        }
        else {
            $usr = login(dbconnect_insert(), $_POST["email"]);

            if ($usr && password_verify($_POST["password"], $usr["password"])) {
                session_regenerate_id(true); // new session id after login for security
                $_SESSION["user_id"] = $usr["user_id"];
                $_SESSION["usermessage"] = "You are now logged in.";
                header("Location: dashboard.php");
                exit;
            }
            else {
                // same message for wrong email and wrong password so nobody can check which emails exist
                $_SESSION["usermessage"] = "Invalid email or password.";
                header("Location: sign_in.php");
                exit;
            }
        }
    }
} catch (PDOException $e) {
    error_log($e->getMessage());
    $_SESSION["usermessage"] = "Something went wrong, please try again.";
    header("Location: sign_in.php");
    exit;
} catch (Exception $e) {
    $_SESSION["usermessage"] = "Something went wrong, please try again.";
    header("Location: sign_in.php");
    exit;
}
?>

<html>

<head>
    <title>sign in</title>
    <link rel="stylesheet" href="../assets/styles.css">
</head>

<body>
<div class="register_bar">
    <img id="image-preview" src="../assets/images/gconsole_light.png" alt="Gconsole logo">
    <h1>welcome</h1>
    <p>log in to Gconsole to continue</p>
    <?php if (isset($_SESSION["usermessage"])) { echo '<p class="message">' . e(user_message()) . '</p>'; } ?>
    <form method="post" action=""> <!-- make a form for users to input information-->

        <input type="email" name="email" id="email" placeholder="Email" required>

        <input type="password" name="password" id="Password" placeholder="Password" required>

        <input type='submit' name='login' value='login' />
    </form>
    <p><a href="sign_up.php">new here? sign up</a></p>
</div>
</body>
</html>
