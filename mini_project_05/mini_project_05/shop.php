<?php

?>

<!DOCTYPE html>

<?php
session_start();
require_once "dbconn.php";
require_once "user_common.php";

check_login();
$user = get_user(dbconnect_insert(), $_SESSION["username"]);
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
        <h1>SHOP</h1>
        <p>Welcome <?php echo e($user["firstname"] . " " . $user["surname"]); ?></p>

    </div>
</div>
</body>
</html>


