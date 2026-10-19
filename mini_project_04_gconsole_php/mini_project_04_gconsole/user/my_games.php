<?php
session_start();
require_once "../assets/dbconn.php";
require_once "../assets/user_common.php";

check_login();

// if they came from a console row only show the games for that console
$console_filter = 0;
if (isset($_GET["console"]) && ctype_digit($_GET["console"])) {
    $console_filter = (int)$_GET["console"];
}

try {
    // the remove button posts to this page
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (remove_user_game(dbconnect_insert(), $_SESSION["user_id"])) {
            $_SESSION["usermessage"] = "Game removed from your collection.";
        } else {
            $_SESSION["usermessage"] = "Could not remove that game.";
        }
        header("Location: my_games.php" . ($console_filter > 0 ? "?console=" . $console_filter : ""));
        exit;
    }

    $games = get_user_games(dbconnect_insert(), $_SESSION["user_id"], $console_filter);
} catch (PDOException $e) {
    error_log($e->getMessage());
    echo "Something went wrong, please try again.";
    exit;
}
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

    <div class="table_box">
        <table class="collection_table">
            <thead>
            <tr>
                <th>Game</th>
                <th>Console</th>
                <th>Purchase date</th>
                <th>Disc / Digital</th>
                <th>Price</th>
                <th>Remove</th>
            </tr>
            </thead>
            <tbody>
            <?php if (count($games) == 0) { ?>
                <tr><td colspan="6">No games to show yet.</td></tr>
            <?php } ?>
            <?php foreach ($games as $g) { // one row for each item in the user's collection ?>
            <tr>
                <td><?php echo e($g["game_name"]); ?></td>
                <td><?php echo e($g["console_name"]); ?> (<?php echo e($g["region"]); ?>)</td>
                <td><?php echo e(date("d M Y", strtotime($g["purchase_date"]))); ?></td>
                <td><?php echo e($g["format"]); ?></td>
                <td>£<?php echo number_format($g["price"], 2); ?></td>
                <td>
                    <form method="post" onsubmit="return confirm('Remove this game from your collection?');">
                        <input type="hidden" name="user_game_id" value="<?php echo e($g["user_game_id"]); ?>">
                        <button type="submit" class="remove_btn">Remove</button>
                    </form>
                </td>
            </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</main>

</body>
</html>
