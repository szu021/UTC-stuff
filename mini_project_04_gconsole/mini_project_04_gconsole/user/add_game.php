<?php


//session_start(); # server side storage session lasts like 5 mins
//require_once "assets/common.php";  // bring in the common functions
//require_once "assets/dbconn.php";  // bring in the dbconnection, not ideal way to execute

session_start();

require_once "../assets/dbconn.php";
require_once "../assets/images.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    regcons(dbconnect_insert());
}


?>

<html>

<head>
    <title>Add game</title>
    <link rel="stylesheet" href="../assets/styles.css">
</head>
<body class="dash_page">
<img id="image-preview" src="../assets/images/Gconsole.jpeg" alt="Selected preview">

<?php echo user_message();

$a = makergetter(dbconnect_insert());
foreach ($a

as $m) {
    echo '<option value="' . $m["manufacturer_id"] . '">' . $m["name"] . '</option>';
}?>
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
