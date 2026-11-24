<?php
session_start();
require_once "assets/dbconn.php";
require_once "assets/user_common.php";

check_login();

// the add to basket buttons post back to this page
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $name = add_to_basket(dbconnect_insert());
        $_SESSION["usermessage"] = $name . " added to your basket.";
    } catch (InvalidArgumentException $e) {
        $_SESSION["usermessage"] = $e->getMessage();
    }
    header("Location: shop.php"); // redirect so refreshing doesn't add it twice
    exit;
}

$products = get_products(dbconnect_insert());
$message = user_message();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>shop</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>

<body class="dash_page">
<div class="navi">
    <?php require_once "navi.php"; ?>
</div>

<main>
    <?php if ($message !== "") { echo '<p class="message page_message">' . e($message) . '</p>'; } ?>

    <?php if (count($products) == 0) { ?>
        <p class="message page_message">There are no products in the shop yet.</p>
    <?php } ?>

    <div class="product_grid">
        <?php foreach ($products as $p) { // one card for each product
            $image = product_image($p["image_name"]); ?>
            <div class="product">
                <?php if ($image != "") { ?>
                    <img class="product_image" src="<?php echo e($image); ?>" alt="<?php echo e($p["product_name"]); ?>">
                <?php } else { ?>
                    <div class="product_image">image</div>
                <?php } ?>

                <h2><?php echo e($p["product_name"]); ?></h2>
                <p class="product_description"><?php echo e($p["product_description"]); ?></p>
                <p class="product_price"><?php echo e(money($p["product_price"])); ?></p>

                <?php if ($p["daily_stock"] > 0) { ?>
                    <form method="post">
                        <input type="hidden" name="product_id" value="<?php echo e($p["product_id"]); ?>">
                        <input type="number" name="quantity" value="1" min="1" max="<?php echo e($p["daily_stock"]); ?>" aria-label="quantity" required>
                        <button type="submit">add to basket</button>
                    </form>
                <?php } else { ?>
                    <p class="sold_out">sold out today</p>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
</main>

</body>
</html>
