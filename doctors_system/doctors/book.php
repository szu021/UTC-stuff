<?php
session_start();
require_once "dbconn.php";
require_once "user_common.php";

check_login();
$patient = get_patient(dbconnect_insert(), $_SESSION["patient_id"]);
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
        <h1>Book an appointment</h1>
        <p>Welcome <?php echo e($patient["firstname"] . " " . $patient["surname"]); ?></p>

    </div>
</div>
</body>
</html>

