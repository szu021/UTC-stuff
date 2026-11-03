<?php
session_start();
require_once "../assets/dbconn.php";
require_once "../assets/user_common.php";

check_login();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    add_user_game(dbconnect_insert(), $_SESSION["user_id"]);
    $_SESSION["usermessage"] = "Game added to your collection.";
    header("Location: add_game.php"); // redirect so refreshing doesn't add it twice
    exit;
}

$my_consoles = get_user_consoles(dbconnect_insert(), $_SESSION["user_id"]); // only consoles they own
?>

<html>

<head>
    <title>Add game</title>
    <link rel="stylesheet" href="../assets/styles.css">
</head>
<body class="dash_page">
<img id="image-preview" src="../assets/images/Gconsole.png" alt="Gconsole logo">


<div class="navi">
    <?php require_once "../assets/user_navi.php"; ?>


    <div class="adder">
        <h1>add game</h1>
        <?php if (isset($_SESSION["usermessage"])) { echo '<p class="message">' . e(user_message()) . '</p>'; } ?>

        <?php if (count($my_consoles) == 0) { ?>
            <!-- a game has to be on a console so they need one first -->
            <p class="message">You need to <a href="add_console.php">add a console</a> before you can add a game.</p>
        <?php } else { ?>
        <form method="post">
            <label for="game_name">game</label>
            <input type="text" name="game_name" id="game_name" placeholder="game name" required>

            <label for="user_console_id">console it is for</label>
            <select name="user_console_id" id="user_console_id" required>
                <?php
                foreach ($my_consoles as $c) { // region and date shown so two of the same console can be told apart
                    echo '<option value="' . e($c["user_console_id"]) . '">' . e($c["console_name"]) . ' - ' . e($c["region"]) . ' (' . e($c["purchase_date"]) . ')</option>';
                }
                ?>
            </select>

            <label for="format">disc / digital</label>
            <select name="format" id="format" required>
                <option value="Disc">Disc</option>
                <option value="Digital">Digital</option>
            </select>

            <label for="purchase">date</label>
            <input type="date" name="purchase" id="purchase" max="<?php echo date("Y-m-d"); ?>" required>

            <label for="price">price</label>
            <input type="number" name="price" id="price" step="0.01" min="0" placeholder="price" required>

            <input type="submit" name="submit" id="submit" value="add">
        </form>
        <?php } ?>
    </div>

</div>
</body>
</html>
