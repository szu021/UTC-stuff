<?php
session_start();
require_once "assets/dbconn.php";
require_once "assets/user_common.php";

check_login();
$user = get_user(dbconnect_insert(), $_SESSION["user_id"]);
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>account</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>

<body class="dash_page">
<div class="navi">
    <?php require_once "navi.php"; ?>
</div>

<main>
    <div class="list_box">
        <h1>your account</h1>
        <div class="list_row"><span>name</span><span><?php echo e($user["firstname"] . " " . $user["surname"]); ?></span></div>
        <div class="list_row"><span>email</span><span><?php echo e($user["email"]); ?></span></div>
        <div class="list_row"><span>phone</span><span><?php echo e($user["phone_number"]); ?></span></div>
        <div class="list_row"><span>address</span><span><?php echo e($user["home_address"]); ?></span></div>
        <a class="box_btn" href="orders.php">your orders</a>
        <a class="box_btn" href="logout.php">logout</a>
    </div>
</main>

</body>
</html>
