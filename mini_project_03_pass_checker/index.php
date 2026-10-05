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
<head> <!-- The head of the page, usually has the title, which is the tab's name as well as the link to the stylesheet to decorate the website. -->
    <title>Homepage</title>
    <link rel="stylesheet" href="assets/styles.css">

</head>
<body>
<?php

echo user_message()



?>
<h1>Form</h1>
<form method="post" action="">
    <div class="form">
        <label for="enter"><strong>enter olt</strong></label><br>
        <input type="text" name="message"  placeholder="message" required>
        <br><br>
        <input type='submit' name='submit'  />
    </div>
</form>

</body>
</html>
