<?php

session_start();
require_once("assets/common.php");
//     creates sever and sens through
if ($_SERVER["REQUEST_METHOD"] === "POST") {
//    creates session variable linked to form
    //$_SESSION["message"] = $_POST["message"];
    if (string_length($_POST["password"])) {
        $_SESSION["message"] = "password is a fine length";
    } else {
        $_SESSION["message"] = "pass too short";
    }
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


<div class="pass_info">
<form method="post" action="">

        <label for="enter">enter Password:</label>
        <input type="text" name="password"  placeholder="password" required>
        <br><br>

        <input type='submit' name='submit'/>

</form>
</div>
<br><br>
<br><br>
<br><br>
<h2>Feedback:</h2>
<div class="user_message">
<?php
$pswd = $_POST["password"];
$array = ["No Uppercase used", "Uppercase used"];
echo user_message();
echo nl2br("\n");
echo length_output();
echo nl2br("\n");
echo $array[hasUpperCase($pswd)];

?>
</div>
</body>
</html>
