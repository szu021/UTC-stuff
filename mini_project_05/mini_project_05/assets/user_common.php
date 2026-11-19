<?php

function user_message()
{
    $message = "";
    if (isset($_SESSION["usermessage"])) {
        $message = $_SESSION["usermessage"];
        unset($_SESSION["usermessage"]);
    }
    return $message;
}

function e($text)
{
    return htmlspecialchars($text);
}

function check_login()
{
    if (!isset($_SESSION["user_id"])) {
        header("Location: login.php");
        exit;
    }
}

function onlyuser($conn, $email)
{
    $sql = "SELECT email FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $email);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $conn = null;
    return $result ? false : true;
}

function reg_user($conn)
{
    $sql = "INSERT INTO users (firstname, surname, phone_number, home_address, dob, email, password ) VALUES (?,?,?,?,?,?,?)";
    $stmt = $conn->prepare($sql);

    $hashed = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $stmt->bindParam(1, $_POST["firstname"]);
    $stmt->bindParam(2, $_POST["surname"]);
    $stmt->bindParam(3, $_POST["phone_number"]);
    $stmt->bindParam(4, $_POST["home_address"]);
    $stmt->bindParam(5, $_POST["dob"]);
    $stmt->bindParam(6, $_POST["email"]);
    $stmt->bindParam(7, $hashed);
    $stmt->execute();

    $id = $conn->lastInsertId();
    $conn = null;
    return $id;
}

function login($conn, $email)
{
    $sql = "SELECT User_ID AS user_id, password FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $email);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $conn = null;
    return $result;
}

function get_user($conn, $id)
{
    $sql = "SELECT firstname, surname FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $conn = null;
    return $result;
}

function remove_booking($conn){
//    removes console from list
    $sql = "DELETE FROM booking WHERE booking_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $_POST["booking_id"]);
    $stmt->execute();
    $conn = null;
    return true;
}

