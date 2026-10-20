<?php
function dbconnect_insert()
{
    $servername = "localhost";  //sets servername
    $dbusername = "root";       // database username
    $dbpassword = "";           // password for database useraccount
    $dbname = "gconsole";       //database name to connect to

    $conn = new PDO("mysql:host=$servername;port=3306;dbname=$dbname", $dbusername, $dbpassword);  // creates a PDO connection to the database
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //sets error modes
    return $conn;
}


function regmaker($conn){
    // prepare sql
    $sql = "INSERT INTO manufacturer_id (name, location) VALUES(?,?)";
    $stmt = $conn->prepare($sql);

    // list and bind all parameters for security
    $stmt->bindParam(1, $_POST["name"]);
    $stmt->bindParam(2, $_POST["location"]);

    $stmt->execute(); // run the query
    $conn = null; // closes the connection so can't be abused
    return true; // register successful
}

function makergetter($conn){
    // get all the manufacturers for the drop down

    $sql = "SELECT * FROM manufacturer_id ORDER BY name";
    
    $stmt = $conn->prepare($sql);

    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $conn = null;
    return $result;
}


function regcons($conn){
    // prepare sql
    $sql = "INSERT INTO console (manufacturer_id, console_name, cost, os) VALUES(?,?, ?, ?)";
    $stmt = $conn->prepare($sql);

    // list and bind all parameters for security
    $stmt->bindParam(1, $_POST["manufacturer"]);
    $stmt->bindParam(2, $_POST["console_name"]);
    $stmt->bindParam(3, $_POST["cost"]);
    $stmt->bindParam(4, $_POST["os"]);

    $stmt->execute(); // run the query
    $conn = null; // closes the connection so can't be abused
    return true; // register successful
}