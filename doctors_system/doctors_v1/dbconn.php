<?php
function dbconnect_insert()
{
    $servername = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "doctors_surgery";

    $conn = new PDO("mysql:host=$servername;port=3306;dbname=$dbname", $dbusername, $dbpassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $conn;
}
