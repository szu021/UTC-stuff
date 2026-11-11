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


function doc_getter($conn)
{
    $sql = "SELECT * FROM doctors";

    $stmt = $conn->prepare($sql);

    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $conn = null;
    return $result;
}

function make_booking($conn){
    $dt= new DateTime($_POST["appt-time"]);
    #industry standard conversion as data type mismatch
    $mysql_datetime = $dt->format("Y-m-d H:i:s");

}
