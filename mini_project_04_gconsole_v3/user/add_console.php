<?php
session_start();
require_once "../assets/dbconn.php";
require_once "../assets/user_common.php";

check_login();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    add_user_console(dbconnect_insert(), $_SESSION["user_id"]);
    $_SESSION["usermessage"] = "Console added to your collection.";
    header("Location: add_console.php"); // redirect so refreshing doesn't add it twice
    exit;
}
?>

<html>

<head>
    <title>Add Console</title>
    <link rel="stylesheet" href="../assets/styles.css">
</head>
<body class="dash_page">
<img id="image-preview" src="../assets/images/Gconsole.png" alt="Gconsole logo">


<div class="navi">
    <?php require_once "../assets/user_navi.php"; ?>


    <div class="adder">
        <h1>Add Console</h1>
        <?php if (isset($_SESSION["usermessage"])) { echo '<p class="message">' . e(user_message()) . '</p>'; } ?>
        <form method="post">
            <label for="console_name">Console</label>
            <input type="text" name="console_name" id="console_name" placeholder="console name" required>

            <label for="region">Region</label>
            <select name="region" id="region" required>
                <?php
                foreach (region_list() as $r) {
                    echo '<option value="' . e($r) . '">' . e($r) . '</option>';
                }
                ?>
            </select>

            <label for="purchase">Date Of Purchase</label>
            <input type="date" name="purchase" id="purchase" max="<?php echo date("Y-m-d"); ?>" required>

            <label for="price">Price</label>
            <input type="number" name="price" id="price" step="0.01" min="0" placeholder="price" required>
            <input type="submit" name="submit" id="submit" value="add">
        </form>
    </div>

</div>
</body>
</html>
