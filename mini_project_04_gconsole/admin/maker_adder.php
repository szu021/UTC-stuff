<?php
//session_start(); # server side storage session lasts like 5 mins
//require_once "assets/common.php";  // bring in the common functions
//require_once "assets/dbconn.php";  // bring in the dbconnection, not ideal way to execute

session_start();

require_once "../assets/dbconn.php";
require_once "../assets/images.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    regmaker(dbconnect_insert());
}

//?>
<html>
<head> <!-- The head of the page, usually has the title, which is the tab's name as well as the link to the stylesheet to decorate the website. -->
    <title>maker adder</title>
    <link rel="stylesheet" href="styles.css"

</head>
<body>

<h1>Gconsole</h1>
<h1>maker adder</h1>

<form method= "post" action="maker_adder.php">
    <div class="label_div">


        <label for="manufacturer"><strong>enter a manufacturer:</strong></label>
        <input type="text" name="manufacturer" id="manufacturer" placeholder="manufacturer" required><br>

        <label for="name"><strong>name:</strong></label>
        <input type="text" name="name" id="name" placeholder="name" required><br>

        <label for="location"><strong>location:</strong></label>
        <input type="text" name="location" id="location" placeholder="location" required><br>



        <input type="submit" name="submit" id="submit" placeholder="submit" required>

</form>
