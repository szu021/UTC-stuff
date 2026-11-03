<?php




function user_message(){
    $message = "";
    if(isset($_SESSION["usermessage"])) {
        $message = $_SESSION["usermessage"];
        unset($_SESSION["usermessage"]); // only shows once then is removed
    }
    return $message;
}


# checks the user is logged in, if not sends them to sign in
function check_login(){
    if (!isset($_SESSION["user_id"])) {
        $_SESSION["usermessage"] = "Please sign in first.";
        header("Location: sign_in.php");
        exit;
    }
}




# only user
function onlyuser($conn, $email){
    $sql = "SELECT email FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $email);
    $stmt->execute(); //run sql
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $conn = null;
    if ($result) {
        return false;
    } else {
        return true;
    }
}

# user reg
function reg_user($conn){
    // prepare sql
    $sql = "INSERT INTO users (email, password) VALUES(?,?)";
    $stmt = $conn->prepare($sql);

    $hashed = password_hash($_POST["password"], PASSWORD_DEFAULT); // hashes password


    $stmt->bindParam(1, $_POST["email"]);
    $stmt->bindParam(2, $hashed);

    $stmt->execute(); // run the query
    $conn = null;
    return true;
}

# user login
function login($conn, $email){
    $sql = "SELECT user_id, password FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $email);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $conn = null;

    if ($result) {
        return $result;
    } else {
        return false;
    }
}



