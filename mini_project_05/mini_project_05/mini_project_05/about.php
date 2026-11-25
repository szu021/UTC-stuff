<?php
session_start();
require_once "assets/dbconn.php";
require_once "assets/user_common.php";

check_login();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>about</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>

<body class="dash_page">
<div class="navi">
    <?php require_once "navi.php"; ?>
</div>

<main class="about">
    <h1>Our Story</h1>
    <div class="about_image">template image</div>
    <h2>INFORMATION ABOUT</h2>
</main>

</body>
</html>
