<?php

session_start();
require_once("assets/common.php");
//     creates sever and sens through
if ($_SERVER["REQUEST_METHOD"] === "POST") {
//    creates session variable linked to form
    $_SESSION["message"] = $_POST["message"];
}

?>

<html>
<head>
    <title>password checker</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>

<h1>password checker</h1>
<div class="navi">
    <a class ="linktext" href="index.php">Home Page</a>
</div>


<form method="post" action="">
    <div class="pass_info">
        <label for="enter">enter Password:</label>
        <input type="text" name="message"  placeholder="message" required>
        <br>
        <input type='submit' name='submit' id="Enter"  />
    </div>
</form>

<br><br>
<h2>Feedback:</h2>
<?php
echo user_message()
?>
</body>
</html>
