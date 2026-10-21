<?php
session_start();
require_once "../assets/dbconn.php";
require_once "../assets/user_common.php";

check_login();

// the remove button posts to this page
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    remove_user_console(dbconnect_insert(), $_SESSION["user_id"]);
    $_SESSION["usermessage"] = "Console removed from your collection.";
    header("Location: my_consoles.php");
    exit;
}

$consoles = get_user_consoles(dbconnect_insert(), $_SESSION["user_id"]);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>My Consoles</title>
    <link rel="stylesheet" href="../assets/styles.css">
</head>
<body class="dash_page">
    <img id="image-preview" src="../assets/images/Gconsole.png" alt="Gconsole logo">


    <div class="navi">
        <?php require_once "../assets/user_navi.php"; ?>
    </div>

    <main class="collection">
        <h1>My Consoles</h1>
        <?php if (isset($_SESSION["usermessage"])) { echo '<p class="message">' . e(user_message()) . '</p>'; } ?>

        <table class="collection_table">
            <tr>
                <th>Console</th>
                <th>Purchase date</th>
                <th>Region</th>
                <th>Price</th>
                <th>Games</th>
                <th>Remove</th>
            </tr>
            <?php foreach ($consoles as $c) { // one row for each console the user owns ?>
            <tr>
                <td><?php echo e($c["console_name"]); ?></td>
                <td><?php echo e($c["purchase_date"]); ?></td>
                <td><?php echo e($c["region"]); ?></td>
                <td>£<?php echo e($c["price"]); ?></td>
                <!-- links to the games page showing only this console's games -->
                <td><a href="my_games.php?console=<?php echo e($c["user_console_id"]); ?>"><?php echo e($c["game_count"]); ?> game(s)</a></td>
                <td>
                    <form method="post">
                        <input type="hidden" name="user_console_id" value="<?php echo e($c["user_console_id"]); ?>">
                        <button type="submit" class="remove_btn">Remove</button>
                    </form>
                </td>
            </tr>
            <?php } ?>
        </table>
    </main>

</body>
</html>
