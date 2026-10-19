<?php
session_start();
require_once "../assets/dbconn.php";
require_once "../assets/user_common.php";

check_login(); // sends them to sign in if they are not logged in

try {
    $stats = get_stats(dbconnect_insert(), $_SESSION["user_id"]); // numbers for the boxes
} catch (PDOException $e) {
    error_log($e->getMessage());
    echo "Could not load your dashboard.";
    exit;
}

// total spent on consoles and games together
$total_spent = $stats["console_spent"] + $stats["game_spent"];
?>

<html>

<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="../assets/styles.css">
</head>
<body class="dash_page">
<img id="image-preview" src="../assets/images/Gconsole.png" alt="Gconsole logo">


<div class="navi">
    <?php require_once "../assets/user_navi.php"; ?>

    <div class="dash_box">
        <p>welcome to Gconsole</p>
        <p>Your collection at a glance</p>
        <p><?php echo e($stats["consoles"]); ?><br>consoles owned</p>
        <p><?php echo e($stats["games"]); ?><br>games owned</p>
        <p><?php echo e($stats["regions"]); ?><br>regions collected</p>
        <p>£<?php echo number_format($total_spent, 2); ?><br>total spent</p>
        <p><?php echo $stats["latest_console"] ? e(date("d M Y", strtotime($stats["latest_console"]))) : "none yet"; ?><br>last console bought</p>
        <p><?php echo $stats["latest_game"] ? e(date("d M Y", strtotime($stats["latest_game"]))) : "none yet"; ?><br>last game bought</p>
    </div>

</div>
</body>
</html>
