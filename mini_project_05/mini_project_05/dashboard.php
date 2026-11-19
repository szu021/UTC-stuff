<?php
session_start();
require_once "assets/user_common.php";
check_login();
?>
<!DOCTYPE html>
<html>

<head>
    <title>home</title>
    <link rel="stylesheet" href="assets/styles.css">

</head>

<body>
<div class="navi">
    <?php require_once "navi.php"; ?>
    <div class="register_bar">
        <h1>HOME PAGE</h1>


    </div>
</div>
</body>
</html>

