<?php
// shared functions for the user pages (sign up, sign in, dashboard, consoles and games)
// the connection is made in dbconn.php, every function here is given the connection to use


# user message
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
function onlyuser($conn, $email){ // at registration check to make sure there none of the same
    $sql = "SELECT email FROM users WHERE email = ?"; // check if the inputted email is already in the emails
    $stmt = $conn->prepare($sql); // prepare sql
    $stmt->bindParam(1, $email);
    $stmt->execute(); //run sql
    $result = $stmt->fetch(PDO::FETCH_ASSOC); // bring results
    $conn = null;
    if ($result) { // if user is returned
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

    $hashed = password_hash($_POST["password"], PASSWORD_DEFAULT); // use a hashing algorithm to encrypt the password

    // list and bind all parameters for security
    $stmt->bindParam(1, $_POST["email"]);
    $stmt->bindParam(2, $hashed);

    $stmt->execute(); // run the query
    $conn = null; // closes the connection so can't be abused
    return true; // register successful
}

# user login
function login($conn, $email){
    $sql = "SELECT user_id, password FROM users WHERE email = ?"; // ? stops sql injection
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $email);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC); // emails are unique so only one row
    $conn = null;

    if ($result) {
        return $result;
    } else {
        return false;
    }
}



