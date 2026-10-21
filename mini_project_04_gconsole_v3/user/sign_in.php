<?php
session_start(); // sessions are needed to remember who is logged in
require_once "../assets/dbconn.php";
require_once "../assets/user_common.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usr = login(dbconnect_insert(), $_POST["email"]);

    if ($usr && password_verify($_POST["password"], $usr["password"])) {
        $_SESSION["user_id"] = $usr["user_id"];
        header("Location: dashboard.php");
        exit;
    }
    else {
        $_SESSION["usermessage"] = "Invalid email or password.";
        header("Location: sign_in.php");
        exit;
    }
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
