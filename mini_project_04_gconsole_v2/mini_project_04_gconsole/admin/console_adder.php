


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
<head> <!-- The head of the page, usually has the title, which is the tab's name as well as the link to the stylesheet to decorate the website. -->
    <title>console adder</title>


</head>
<body>

<h1>Gconsole</h1>
<h1>console adder</h1>

<form method= "post" action="console_adder.php">
    <div class="label_div">

        <label for="manufacturer"><strong> manufacturer:</strong></label>
        <select name="manufacturer" id="manufacturer">
            <?php
                $a = makergetter(dbconnect_insert());
                foreach ($a as $m) {
                    echo '<option value="' . $m["manufacturer_id"] . '">' . $m["name"] . '</option>';
                }
            ?>
        </select><br>


        <label for="console_name"><strong>enter a console_name:</strong></label>
        <input type="text" name="console_name" id="console_name" placeholder="console name" required><br>

        <label for="cost"><strong>cost:</strong></label>
        <input type="text" name="cost" id="cost" placeholder="cost kaching" required><br>

        <label for="os"><strong>location:</strong></label>
        <input type="text" name="os" id="os" placeholder="location" required><br>

        <button type="submit">top 10 moments</button>
    </div>

</form>

