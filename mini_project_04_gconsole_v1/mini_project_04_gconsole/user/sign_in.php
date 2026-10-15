<?php


require_once "assets/common.php";
require_once "assets/dbconn.php";

$_SESSION['Title'] = "Sign In";


try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (!isset($_SESSION["student_id"])) {
            $_SESSION["usermessage"] = "You are already logged in.";
            header("Location: students.php");
            exit;
        } elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
            $usr = login(dbconnect_insert(), $_POST["email"]);

            if ($usr && password_verify($_POST["password"], $usr["password"])) {
                $_SESSION["usermessage"] = "You are now logged in.";
                $_SESSION["student_id"] = getuserid(dbconnect_insert(), $_POST["email"]);
                header("Location: students.php");
                exit;
            } elseif (!$usr) {
                $_SESSION["usermessage"] = "invalid email or password.";
                header("Location: signin.php");
            } else {
                $_SESSION["usermessage"] = "something went wrong.";
                header("Location: signin.php");
                exit;
            }
        }
    }
} catch (PDOException $e) {
    $_SESSION['usermessage'] = $e->getMessage();
    header("Location: signin.php");
    exit;
} catch (Exception $e) {
    $_SESSION['usermessage'] = $e->getMessage();
    header("Location: signin.php");
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
    <img id="image-preview" src="../assets/images/gconsole_light.jpeg" alt="Selected preview">
    <h1>welcome</h1>
    <p>log in to Gconsole to continue</p>
    <form method="post" action=""> <!-- make a form for users to input information-->



            <input type="email" name="email" id="email" placeholder="Email" required>

            <input type="password" name="password" id="Password" placeholder="Password" required>

            <input type='submit' name='login' value='login' />





</div>
</body>
</html>
