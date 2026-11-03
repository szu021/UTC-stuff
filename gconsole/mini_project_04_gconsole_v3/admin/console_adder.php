<?php
require_once '../assets/dbconn.php';   // brings in the database connection

// this only runs when the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    regcons(dbconnect_insert()); // add the console
}

// get the manufacturers so the drop down box has something in it
$makers = makergetter(dbconnect_insert());
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>console adder</title>
</head>
<body>

<h1>Gconsole</h1>
<h1>console adder</h1>

<form method="post" action="console_adder.php">
    <div class="label_div">

        <label for="manufacturer"><strong>manufacturer:</strong></label>
        <select name="manufacturer" id="manufacturer" required>
            <option value="">Select a manufacturer</option>
            <?php
            // one option for each manufacturer, the value is the id and the text is the name
            foreach ($makers as $m) {
                echo '<option value="' . $m["manufacturer_id"] . '">' . $m["name"] . '</option>';
            }
            ?>
        </select><br>

        <label for="console_name"><strong>console name:</strong></label>
        <input type="text" name="console_name" id="console_name" placeholder="console name" required><br>

        <label for="cost"><strong>cost:</strong></label>
        <input type="text" name="cost" id="cost" placeholder="cost" required><br>

        <label for="os"><strong>operating system:</strong></label>
        <input type="text" name="os" id="os" placeholder="operating system" required><br>

        <button type="submit">add console</button>
    </div>

</form>

</body>
</html>
