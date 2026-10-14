<?php
# user login
function login($conn, $email){
    $sql = "SELECT email, password FROM accounts WHERE email = ?";
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