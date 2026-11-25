<?php
session_start();
require_once "assets/dbconn.php";
require_once "assets/user_common.php";

check_login();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["checkout"])) {
        try {
            checkout(dbconnect_insert(), $_SESSION["user_id"]);
            $_SESSION["usermessage"] = "Thank you, your order has been placed.";
            header("Location: orders.php");
            exit;
        } catch (InvalidArgumentException $e) {
            $_SESSION["usermessage"] = $e->getMessage();
        }
    } else {
        remove_from_basket();
        $_SESSION["usermessage"] = "Item removed from your basket.";
    }
    header("Location: basket.php");
    exit;
}

$items = get_basket_items(dbconnect_insert());
$message = user_message();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>basket</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>

<body class="dash_page">
<div class="navi">
    <?php require_once "navi.php"; ?>
</div>

<main>
    <div class="list_box">
        <h1>Basket</h1>
        <?php if ($message !== "") { echo '<p class="message">' . e($message) . '</p>'; } ?>

        <?php if (count($items) == 0) { ?>
            <p class="message">Your basket is empty.</p>
        <?php } else { ?>
            <table class="list_table">
                <?php foreach ($items as $i) { // one row for each item in the basket ?>
                    <tr>
                        <td><?php echo e($i["product_name"]); ?> x <?php echo e($i["quantity"]); ?></td>
                        <td class="price"><?php echo e(money($i["line_total"])); ?></td>
                        <td>
                            <form method="post">
                                <input type="hidden" name="product_id" value="<?php echo e($i["product_id"]); ?>">
                                <button type="submit" class="remove_btn">remove</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
                <tr class="subtotal">
                    <td>subtotal</td>
                    <td class="price"><?php echo e(money(basket_total($items))); ?></td>
                    <td></td>
                </tr>
            </table>

            <form method="post" class="checkout_form">
                <button type="submit" name="checkout" class="checkout_btn">checkout</button>
            </form>
        <?php } ?>
    </div>
</main>

</body>
</html>
