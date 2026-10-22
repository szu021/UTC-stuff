<?php
session_start();
require_once "../assets/dbconn.php";
require_once "../assets/user_common.php";

check_login();

try {
    // the remove button posts to this page
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (remove_user_console(dbconnect_insert(), $_SESSION["user_id"])) {
            $_SESSION["usermessage"] = "Console removed from your collection.";
        } else {
            $_SESSION["usermessage"] = "Could not remove that console.";
        }
        header("Location: my_consoles.php");
        exit;
    }

    $consoles = get_user_consoles(dbconnect_insert(), $_SESSION["user_id"]);
} catch (PDOException $e) {
    error_log($e->getMessage());
    echo "Something went wrong, please try again.";
    exit;
}
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

        <div class="table_box">
            <table class="collection_table">
                <thead>
                <tr>
                    <th>Console</th>
                    <th>Purchase date</th>
                    <th>Region</th>
                <th>Price</th>
                <th>Games</th>
                <th>Remove</th>
            </tr>
            </thead>
            <tbody>
            <?php if (count($consoles) == 0) { ?>
                <tr><td colspan="6">You haven't added any consoles yet.</td></tr>
            <?php } ?>
            <?php foreach ($consoles as $c) { // one row for each item in the user's collection ?>
            <tr>
                <td><?php echo e($c["console_name"]); ?></td>
                <td><?php echo e(date("d M Y", strtotime($c["purchase_date"]))); ?></td>
                <td><?php echo e($c["region"]); ?></td>
                <td>£<?php echo number_format($c["price"], 2); ?></td>
                <!-- links to the games page filtered to this console -->
                <td><a href="my_games.php?console=<?php echo e($c["user_console_id"]); ?>"><?php echo e($c["game_count"]); ?> game(s)</a></td>
                <td>
                    <form method="post" onsubmit="return confirm('Remove this console? Any games you have on it will be removed too.');">
                        <input type="hidden" name="user_console_id" value="<?php echo e($c["user_console_id"]); ?>">
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
