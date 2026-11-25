<?php
session_start();
require_once "assets/dbconn.php";
require_once "assets/user_common.php";

check_login();
$orders = get_orders(dbconnect_insert(), $_SESSION["user_id"]);
$message = user_message();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>your orders</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>

<body class="dash_page">
<div class="navi">
    <?php require_once "navi.php"; ?>
</div>

<main>
    <div class="list_box wide">
        <h1>your orders</h1>
        <?php if ($message !== "") { echo '<p class="message">' . e($message) . '</p>'; } ?>

        <?php if (count($orders) == 0) { ?>
            <p class="message">You have no orders yet.</p>
        <?php } else { ?>
            <table class="list_table">
                <tr>
                    <th>item</th>
                    <th>dispatch date</th>
                    <th class="price">price</th>
                </tr>
                <?php foreach ($orders as $o) { // one row for each item ordered ?>
                    <tr>
                        <td><?php echo e($o["product_name"]); ?> x <?php echo e($o["quantity"]); ?></td>
                        <td><?php echo e($o["collection_or_delivery_date"]); ?></td>
                        <td class="price"><?php echo e(money($o["line_total"])); ?></td>
                    </tr>
                <?php } ?>
            </table>
        <?php } ?>
    </div>
</main>

</body>
</html>
