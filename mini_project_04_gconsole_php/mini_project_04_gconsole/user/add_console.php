<?php
session_start();
require_once "../assets/dbconn.php";
require_once "../assets/user_common.php";

check_login();

try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // server side checks as the html checks can be bypassed
        if (!valid_date($_POST["purchase"])) {
            $_SESSION["usermessage"] = "Please enter a valid purchase date that is not in the future.";
        }
        elseif (!is_numeric($_POST["price"]) || $_POST["price"] < 0) {
            $_SESSION["usermessage"] = "Price must be 0 or more.";
        }
        elseif (!in_array($_POST["region"], region_list())) {
            $_SESSION["usermessage"] = "Please pick a region from the list.";
        }
        elseif (add_user_console(dbconnect_insert(), $_SESSION["user_id"])) {
            $_SESSION["usermessage"] = "Console added to your collection.";
        }
        else {
            $_SESSION["usermessage"] = "That console does not exist.";
        }
        header("Location: add_console.php"); // redirect so refreshing doesn't add it twice
        exit;
    }

    $consoles = get_consoles(dbconnect_insert()); // for the drop down
} catch (PDOException $e) {
    error_log($e->getMessage());
    echo "Something went wrong, please try again.";
    exit;
}
?>

<html>

<head>
    <title>Add Console</title>
    <link rel="stylesheet" href="../assets/styles.css">
</head>
<body class="dash_page">
<img id="image-preview" src="../assets/images/Gconsole.jpeg" alt="Gconsole logo">


<div class="navi">
    <?php require_once "../assets/user_navi.php"; ?>


    <div class="adder">
        <h1>add console</h1>
        <?php if (isset($_SESSION["usermessage"])) { echo '<p class="message">' . e(user_message()) . '</p>'; } ?>
        <form method="post">
            <label for="console_id">console</label>
            <select name="console_id" id="console_id" required>
                <option value="">Select a console</option>
                <?php
                foreach ($consoles as $c) { // one option per console the admin has added
                    echo '<option value="' . e($c["console_id"]) . '">' . e($c["console_name"]) . '</option>';
                }
                ?>
            </select>

            <label for="region">region</label>
            <select name="region" id="region" required>
                <?php
                foreach (region_list() as $r) {
                    echo '<option value="' . e($r) . '">' . e($r) . '</option>';
                }
                ?>
            </select>

            <label for="purchase">date of purchase</label>
            <input type="date" name="purchase" id="purchase" max="<?php echo date("Y-m-d"); ?>" required>
            <!--    step and min for currency so negative cant be added and decimals can be -->
            <label for="price">price</label>
            <input type="number" name="price" id="price" step="0.01" min="0" placeholder="price" required>
            <input type="submit" name="submit" id="submit" value="add">
        </form>
    </div>

</div>
</body>
</html>
