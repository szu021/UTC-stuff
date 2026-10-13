<?php

?>

<html>

<head>
    <title>Add game</title>
    <link rel="stylesheet" href="../assets/styles.css">
</head>
<body class="dash_page">
<img id="image-preview" src="../assets/images/Gconsole.jpeg" alt="Selected preview">


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
            <input type="number" name="price" id="price" step="0.01" min="0" placeholder="price" required>
            <input type="submit" name="submit" id="submit" value="add">
        </form>
    </div>

</div>
</body>
</html>
