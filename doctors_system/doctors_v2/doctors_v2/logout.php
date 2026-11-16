<?php
session_start();
session_destroy(); // removes the login so the user has to sign in again
header("Location: index.html");
exit;
?>
