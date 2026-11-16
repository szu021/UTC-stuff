<?php
session_start();
require_once "dbconn.php";
require_once "user_common.php";

check_login();
$patient = get_patient(dbconnect_insert(), $_SESSION["patient_id"]);
$appointments = appt_getter(dbconnect_insert(), $_SESSION["patient_id"]);
$message = user_message();
?>

<!DOCTYPE html>
<html>

<head>
    <title>appointment booking</title>
    <link rel="stylesheet" href="assets/styles.css">

</head>

<body>
<div class="navi">
    <?php require_once "navi.php"; ?>
    <div class="register_bar">
        <h1>Your Account</h1>
        <p>Welcome <?php echo e($patient["firstname"] . " " . $patient["surname"]); ?></p>
        <p>change email</p>
        <p>change password</p>