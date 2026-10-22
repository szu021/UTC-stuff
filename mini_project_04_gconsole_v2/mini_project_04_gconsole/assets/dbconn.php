<?php
function dbconnect_insert()
{
    $servername = "localhost";

    $dbusername = "root";

    $dbpassword = "";

    $dbname = "gconsole";

    try {
        $conn = new PDO("mysql:host=$servername;port=3306;dbname=$dbname", $dbusername, $dbpassword);  // creates a PDO connection to the database
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //sets error modes
        return $conn;
    } catch (PDOException $e) {
        error_log("Database error in super_checker: " . $e->getMessage());
        throw $e;
    }
}


function regmaker($conn){

    $sql = "INSERT INTO manufacturer_id (name, location) VALUES(?,?)";
    $stmt = $conn->prepare($sql);


    $stmt->bindParam(1, $_POST["name"]);
    $stmt->bindParam(2, $_POST["location"]);

    $stmt->execute();
    $conn = null;
    return true;
}

function makergetter($conn){
    // function to get all the schools for a drop down

    $sql = "SELECT * FROM manufacturer_id";
    //get all schools in system
    $stmt = $conn->prepare($sql);

    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $conn = null;
    return $result;
}


function regcons($conn){

    $sql = "INSERT INTO console (manufacturer_id, console_name, cost, os) VALUES(?,?, ?, ?)";
    $stmt = $conn->prepare($sql);


    $stmt->bindParam(1, $_POST["manufacturer"]);
    $stmt->bindParam(2, $_POST["console_name"]);
    $stmt->bindParam(3, $_POST["cost"]);
    $stmt->bindParam(4, $_POST["os"]);

    $stmt->execute();
    $conn = null;
    return true;
}