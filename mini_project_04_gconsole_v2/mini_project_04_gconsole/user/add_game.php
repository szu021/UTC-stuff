<?php
session_start();
require_once "../assets/dbconn.php";
require_once "../assets/user_common.php";

check_login();

try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (!valid_date($_POST["purchase"])) {
            $_SESSION["usermessage"] = "Please enter a valid purchase date that is not in the future.";
        }
        elseif (!is_numeric($_POST["price"]) || $_POST["price"] < 0) {
            $_SESSION["usermessage"] = "Price must be 0 or more.";
        }
        elseif (!in_array($_POST["format"], ["Disc", "Digital"])) {
            $_SESSION["usermessage"] = "Please pick disc or digital.";
        }
        else {
            $result = add_user_game(dbconnect_insert(), $_SESSION["user_id"]);
            if ($result === true) {
                $_SESSION["usermessage"] = "Game added to your collection.";
            } else {
                $_SESSION["usermessage"] = $result; // the function sends back the reason it failed
            }
        }
        header("Location: add_game.php"); // redirect so refreshing doesn't add it twice
        exit;
    }

    $games = get_games(dbconnect_insert()); // for the game drop down
    $my_consoles = get_user_consoles(dbconnect_insert(), $_SESSION["user_id"]); // only consoles they own
} catch (PDOException $e) {
    error_log($e->getMessage());
    echo "Something went wrong, please try again.";
    exit;
}
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
            <label for="game_id">game</label>
            <select name="game_id" id="game_id" required>
                <option value="">Select a game</option>
                <?php
                foreach ($games as $g) {
                    echo '<option value="' . e($g["game_id"]) . '">' . e($g["name"]) . '</option>';
                }
                ?>
            </select>

            <label for="user_console_id">console it is for</label>
            <select name="user_console_id" id="user_console_id" required>
                <?php
                foreach ($my_consoles as $c) { // shows region and date so two of the same console can be told apart
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

            <!--    step and min for currency so negative cant be added and decimals can be -->
            <label for="price">price</label>
            <input type="number" name="price" id="price" step="0.01" min="0" placeholder="price" required>

            <input type="submit" name="submit" id="submit" value="add">
        </form>
        <?php } ?>
    </div>

</div>
</body>
</html>
