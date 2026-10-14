<?php


function user_message(){
    $message = "";
    if(isset($_SESSION["usermessage"])) {
        $message = $_SESSION["usermessage"];
        unset($_SESSION["usermessage"]);
    }
    return $message;
}

# user login
function login($conn, $email){
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $email);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $conn = null;

    if ($result) {
        return $result;
    } else {
        return false;
    }
}


function getuserid($conn, $email){
    $sql = "SELECT user_id, password FROM users WHERE email = ?"; // get only one student_id since there's unique emails (meaning only one can exist)
    $stmt = $conn->prepare($sql); // prepare
    $stmt->bind_param(1, $email); // bind the param for security
    $stmt->execute(); // run sql
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result["users"];
}