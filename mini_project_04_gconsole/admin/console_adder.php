<?php
session_start(); # server side storage session lasts like 5 mins
require_once "assets/common.php";  // bring in the common functions
require_once "assets/dbconn.php";  // bring in the dbconnection, not ideal way to execute
?>

<html>
<head> <!-- The head of the page, usually has the title, which is the tab's name as well as the link to the stylesheet to decorate the website. -->
    <title>console adder</title>
    <link rel="stylesheet" href="styles.css"

</head>
<body>

<h1>Gconsole</h1>
<h1>console adder</h1>

<form method= "post" action="">
    <div class="label_div">

        <label for="manufacturer"><strong> manufacturer:</strong></label>
        <select name="manufacturer" id="manufacturer">
            <?php

            ?>
        </select>

</form>

