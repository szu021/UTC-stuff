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
    if (!isset($_SESSION["patient_id"])) {
        header("Location: login.php");
        exit;
    }
}

function onlyuser($conn, $email)
{
    $sql = "SELECT email_address FROM patients WHERE email_address = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $email);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $conn = null;
    return $result ? false : true;
}

function reg_user($conn)
{
    $sql = "INSERT INTO patients (firstname, surname, email_address, password, home_address, DOB) VALUES (?,?,?,?,?,?)";
    $stmt = $conn->prepare($sql);

    $hashed = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $stmt->bindParam(1, $_POST["firstname"]);
    $stmt->bindParam(2, $_POST["surname"]);
    $stmt->bindParam(3, $_POST["email_address"]);
    $stmt->bindParam(4, $hashed);
    $stmt->bindParam(5, $_POST["home address"]);
    $stmt->bindParam(6, $_POST["DOB"]);
    $stmt->execute();

    $id = $conn->lastInsertId();
    $conn = null;
    return $id;
}

function login($conn, $email)
{
    $sql = "SELECT patient_ID, password FROM patients WHERE email_address = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $email);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $conn = null;
    return $result;
}

function get_patient($conn, $id)
{
    $sql = "SELECT firstname, surname FROM patients WHERE patient_ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $conn = null;
    return $result;
}
