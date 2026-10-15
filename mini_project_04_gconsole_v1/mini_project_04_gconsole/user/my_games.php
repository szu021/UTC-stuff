<?php
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>My Games</title>
    <link rel="stylesheet" href="../assets/styles.css">
</head>
<body class="dash_page">
<img id="image-preview" src="../assets/images/Gconsole.jpeg" alt="Gconsole logo">


<div class="navi">
    <nav>
        <ul>
            <li><a href="dashboard.php"> Dashboard </a></li>
            <li><a href="my_consoles.php"> My Consoles </a></li>
            <li><a href="my_games.php"> My Games </a></li>
            <li><a href="add_console.php"> Add Consoles </a></li>
            <li><a href="add_game.php"> Add games </a></li>
            <li><a href="index.html"> Logout </a></li>
        </ul>
    </nav>
</div>

<main class="collection">
    <h1>My Games</h1>

    <div class="table_box">
        <table class="collection_table">
            <thead>
            <tr>
                <th>Game</th>
                <th>Purchase date</th>
                <th>Disc / Digital</th>
                <th>Price</th>
                <th>Remove</th>
            </tr>
            </thead>
            <tbody>
            <!-- PHP will add one row here for each item in the user's collection -->
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            </tbody>
        </table>
    </div>
</main>

</body>
</html>