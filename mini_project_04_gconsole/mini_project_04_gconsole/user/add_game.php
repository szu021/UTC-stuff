<?php


require_once "assets/common.php";
require_once "assets/dbconn.php";

$_SESSION['Title'] = "Sign In";


try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (!isset($_SESSION["student_id"])) {
            $_SESSION["usermessage"] = "You are already logged in.";
            header("Location: students.php");
            exit;
        } elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
            $usr = login(dbconnect_insert(), $_POST["email"]);

            if ($usr && password_verify($_POST["password"], $usr["password"])) {
                $_SESSION["usermessage"] = "You are now logged in.";
                $_SESSION["student_id"] = getuserid(dbconnect_insert(), $_POST["email"]);
                header("Location: students.php");
                exit;
            } elseif (!$usr) {
                $_SESSION["usermessage"] = "invalid email or password.";
                header("Location: signin.php");
            } else {
                $_SESSION["usermessage"] = "something went wrong.";
                header("Location: signin.php");
                exit;
            }
        }
    }
} catch (PDOException $e) {
    $_SESSION['usermessage'] = $e->getMessage();
    header("Location: signin.php");
    exit;
} catch (Exception $e) {
    $_SESSION['usermessage'] = $e->getMessage();
    header("Location: signin.php");
    exit;
}


?>

<html>

<head>
    <title>Add game</title>
    <link rel="stylesheet" href="../assets/styles.css">
</head>
<body class="dash_page">
<img id="image-preview" src="../assets/images/Gconsole.jpeg" alt="Selected preview">

<?php echo user_message(); ?>
<div class="navi">
    <nav>
        <ul>
            <li><a href="dashboard.php"> Dashboard </a></li>
            <li><a href="my_consoles.php"> My Consoles </a></li>
            <li><a href="my_games.php">  My Games </a></li>
            <li><a href="add_console.php"> Add Consoles </a></li>
            <li><a href="add_game.php"> Add games </a></li>
            <li><a href="index.html" >Logout </a></li>
        </ul>
    </nav>


    <div class="adder">
        <h1>add game</h1>
        <form method="post">
            <label for="game">game</label>
            <input type="text" name="game" id="game" placeholder="game" required>

            <label for="purchase">date</label>
            <input type="date" name="purchase" id="purchase" placeholder="purchase" required>

            <!--    step and min for currency so negative cant be added and decimals can be -->
            <label for="price">price</label>
            <input type="number" name="price" id="price" step="0.10" min="0" placeholder="price" required>

            <label for="developer">developer</label>
            <input type="text" name="developer" id="developer"  placeholder="developer" required>

            <input type="submit" name="submit" id="submit" value="add">
        </form>
    </div>

</div>
</body>
</html>
