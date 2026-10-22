<?php



function reg_developer($conn){
    // prepare sql
    $sql = "INSERT INTO developer (name, location) VALUES(?,?)";
    $stmt = $conn->prepare($sql);


    $stmt->bindParam(1, $_POST["name"]);
    $stmt->bindParam(2, $_POST["location"]);

    $stmt->execute(); // run the query
    $conn = null;
    return true;
}

function get_developers($conn){
    // function to get all the developers for a drop down

    $sql = "SELECT * FROM developer";
    //get all developers in system
    $stmt = $conn->prepare($sql);

    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $conn = null;
    return $result;
}


function reg_publisher($conn){
    // prepare sql
    $sql = "INSERT INTO publisher (name, location) VALUES(?,?)";
    $stmt = $conn->prepare($sql);


    $stmt->bindParam(1, $_POST["name"]);
    $stmt->bindParam(2, $_POST["location"]);

    $stmt->execute(); // run the query
    $conn = null;
    return true;
}

function get_publishers($conn){
    // function to get all the publishers for a drop down

    $sql = "SELECT * FROM publisher";
    //get all publishers in system
    $stmt = $conn->prepare($sql);

    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $conn = null;
    return $result;
}


function reg_game($conn)
{
    // prepare sql
    $sql = "INSERT INTO game (name, developer_id, publisher_id) VALUES(?,?,?)";
    $stmt = $conn->prepare($sql);


    $stmt->bindParam(1, $_POST["name"]);
    $stmt->bindParam(2, $_POST["developer_id"]);
    $stmt->bindParam(3, $_POST["publisher_id"]);

    $stmt->execute(); // run the query
    $conn = null;
    return true;
}
