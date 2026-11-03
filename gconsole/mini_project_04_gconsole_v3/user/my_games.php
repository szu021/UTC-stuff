<?php
session_start();
require_once "../assets/dbconn.php";
require_once "../assets/user_common.php";

check_login();

// if they came from a console row only show the games for that console
$console_filter = 0;
if (isset($_GET["console"])) {
    $console_filter = (int)$_GET["console"];
}

// the remove button posts to this page
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    remove_user_game(dbconnect_insert(), $_SESSION["user_id"]);
    $_SESSION["usermessage"] = "Game removed from your collection.";
    header("Location: my_games.php");
    exit;
}

$games = get_user_games(dbconnect_insert(), $_SESSION["user_id"], $console_filter);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>My Games</title>
    <link rel="stylesheet" href="../assets/styles.css">
</head>
<body class="dash_page">
<img id="image-preview" src="../assets/images/Gconsole.png" alt="Gconsole logo">


<div class="navi">
    <?php require_once "../assets/user_navi.php"; ?>
</div>

<main class="collection">
    <h1>My Games</h1>
    <?php if (isset($_SESSION["usermessage"])) { echo '<p class="message">' . e(user_message()) . '</p>'; } ?>
    <?php if ($console_filter > 0) { ?>
        <p class="message">Showing games for one console. <a href="my_games.php">Show all games</a></p>
    <?php } ?>

    <table class="collection_table">
        <tr>
            <th>Game</th>
            <th>Console</th>
            <th>Purchase date</th>
            <th>Disc / Digital</th>
            <th>Price</th>
            <th>Remove</th>
        </tr>
        <?php foreach ($games as $g) { // one row for each game the user owns ?>
        <tr>
            <td><?php echo e($g["game_name"]); ?></td>
            <td><?php echo e($g["console_name"]); ?> (<?php echo e($g["region"]); ?>)</td>
            <td><?php echo e($g["purchase_date"]); ?></td>
            <td><?php echo e($g["format"]); ?></td>
            <td>£<?php echo e($g["price"]); ?></td>
            <td>
                <form method="post">
                    <input type="hidden" name="user_game_id" value="<?php echo e($g["user_game_id"]); ?>">
                    <button type="submit" class="remove_btn">Remove</button>
                </form>
            </td>
        </tr>
        <?php } ?>
    </table>
</main>

</body>
</html>
