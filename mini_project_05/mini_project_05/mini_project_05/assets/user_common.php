<?php

function user_message()
{
    $message = "";
    if (isset($_SESSION["usermessage"])) {
        $message = $_SESSION["usermessage"];
        unset($_SESSION["usermessage"]);
    }
    return $message;
}

function e($text)
{
    return htmlspecialchars($text);
}

function check_login()
{
    if (!isset($_SESSION["user_id"])) {
        header("Location: login.php");
        exit;
    }
}

function money($amount)
{
    // prices are shown in pounds with 2 decimal places
    return "£" . number_format($amount, 2);
}

function onlyuser($conn, $email)
{
    $sql = "SELECT email FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $email);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $conn = null;
    return $result ? false : true;
}

function reg_user($conn)
{
    $sql = "INSERT INTO users (firstname, surname, phone_number, home_address, email, password) VALUES (?,?,?,?,?,?)";
    $stmt = $conn->prepare($sql);

    $hashed = password_hash($_POST["password"], PASSWORD_DEFAULT); // hash the password

    $stmt->bindParam(1, $_POST["firstname"]);
    $stmt->bindParam(2, $_POST["surname"]);
    $stmt->bindParam(3, $_POST["phone_number"]);
    $stmt->bindParam(4, $_POST["home_address"]);
    $stmt->bindParam(5, $_POST["email"]);
    $stmt->bindParam(6, $hashed);
    $stmt->execute();

    $id = $conn->lastInsertId();
    $conn = null;
    return $id;
}

function login($conn, $email)
{
    $sql = "SELECT User_ID AS user_id, password FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $email);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $conn = null;
    return $result;
}

function get_user($conn, $id)
{
    $sql = "SELECT firstname, surname, phone_number, home_address, email FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $conn = null;
    return $result;
}


/* ------------------------------------------------------------------
   shop and products
------------------------------------------------------------------- */

function get_products($conn)
{
    // every product for the shop page
    $sql = "SELECT product_id, product_name, product_description, product_price, image_name, daily_stock
            FROM products
            ORDER BY product_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $conn = null;
    return $result;
}

function product_image($image_name)
{
    // returns the web path of the product picture, or nothing if the file is not in the folder yet
    $file = basename($image_name); // basename stops anything like ../ in the database name
    if ($file != "" && file_exists(__DIR__ . "/images/products/" . $file)) {
        return "assets/images/products/" . $file;
    }
    return "";
}


/* ------------------------------------------------------------------
   basket
   the basket the user is filling is kept in the session as product_id => quantity
   it only goes into the database when they check out
------------------------------------------------------------------- */

function add_to_basket($conn)
{
    $product_id = (int) $_POST["product_id"];
    $quantity = (int) $_POST["quantity"];

    if ($quantity < 1) {
        throw new InvalidArgumentException("Please choose a quantity of at least 1.");
    }

    $sql = "SELECT product_name, daily_stock FROM products WHERE product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $product_id);
    $stmt->execute();
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    $conn = null;

    if (!$product) {
        throw new InvalidArgumentException("That product could not be found.");
    }

    // what they already have in the basket counts towards the stock limit
    $already = 0;
    if (isset($_SESSION["basket"][$product_id])) {
        $already = $_SESSION["basket"][$product_id];
    }

    if ($already + $quantity > $product["daily_stock"]) {
        $left = $product["daily_stock"] - $already;
        if ($left < 0) {
            $left = 0;
        }
        throw new InvalidArgumentException("Sorry, only " . $left . " more of " . $product["product_name"] . " can be added today.");
    }

    $_SESSION["basket"][$product_id] = $already + $quantity;
    return $product["product_name"];
}

function remove_from_basket()
{
    // takes one product out of the session basket
    unset($_SESSION["basket"][(int) $_POST["product_id"]]);
    return true;
}

function get_basket_items($conn)
{
    // looks up each product in the session basket so the name and price can be shown
    $items = [];
    if (!isset($_SESSION["basket"])) {
        return $items;
    }

    $sql = "SELECT product_id, product_name, product_price FROM products WHERE product_id = ?";
    $stmt = $conn->prepare($sql);

    foreach ($_SESSION["basket"] as $product_id => $quantity) {
        $stmt->bindParam(1, $product_id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $row["quantity"] = $quantity;
            $row["line_total"] = $row["product_price"] * $quantity;
            $items[] = $row;
        }
    }
    $conn = null;
    return $items;
}

function basket_total($items)
{
    $total = 0;
    foreach ($items as $i) {
        $total += $i["line_total"];
    }
    return $total;
}

function checkout($conn, $user_id)
{
    if (empty($_SESSION["basket"])) {
        throw new InvalidArgumentException("Your basket is empty.");
    }

    // a transaction so the order is either saved completely or not at all
    $conn->beginTransaction();
    try {
        // plain text choice for now, everything is delivered the next day
        $type = "Delivery";
        $dispatch = date("Y-m-d", strtotime("+1 day"));
        $booked = date("Y-m-d");

        $sql = "INSERT INTO shipments (user_id, collection_or_deivery, collection_or_delivery_date, booking_date) VALUES (?,?,?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(1, $user_id);
        $stmt->bindParam(2, $type);
        $stmt->bindParam(3, $dispatch);
        $stmt->bindParam(4, $booked);
        $stmt->execute();
        $shipment_id = $conn->lastInsertId();

        foreach ($_SESSION["basket"] as $product_id => $quantity) {
            // FOR UPDATE stops two people buying the last item at the same time
            $check = $conn->prepare("SELECT product_name, daily_stock FROM products WHERE product_id = ? FOR UPDATE");
            $check->bindParam(1, $product_id);
            $check->execute();
            $product = $check->fetch(PDO::FETCH_ASSOC);

            if (!$product) {
                throw new InvalidArgumentException("A product in your basket is no longer sold.");
            }
            if ($product["daily_stock"] < $quantity) {
                throw new InvalidArgumentException("Sorry, there is not enough " . $product["product_name"] . " left to complete your order.");
            }

            $line = $conn->prepare("INSERT INTO basket (shipment_id, product_id, quantity) VALUES (?,?,?)");
            $line->bindParam(1, $shipment_id);
            $line->bindParam(2, $product_id);
            $line->bindParam(3, $quantity);
            $line->execute();

            $stock = $conn->prepare("UPDATE products SET daily_stock = daily_stock - ? WHERE product_id = ?");
            $stock->bindParam(1, $quantity);
            $stock->bindParam(2, $product_id);
            $stock->execute();
        }

        $conn->commit();
    } catch (Exception $e) {
        $conn->rollBack();
        throw $e;
    }

    unset($_SESSION["basket"]); // basket is empty again once the order is placed
    $conn = null;
    return true;
}

function get_orders($conn, $user_id)
{
    // every item the user has ordered with the date it is sent out
    $sql = "SELECT shipments.shipment_id, shipments.collection_or_delivery_date, products.product_name,
                   basket.quantity, (basket.quantity * products.product_price) AS line_total
            FROM shipments
            JOIN basket ON basket.shipment_id = shipments.shipment_id
            JOIN products ON products.product_id = basket.product_id
            WHERE shipments.user_id = ?
            ORDER BY shipments.booking_date DESC, shipments.shipment_id DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $user_id);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $conn = null;
    return $result;
}
