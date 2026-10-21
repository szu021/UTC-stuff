<?php
// functions for the user pages (sign up, sign in, dashboard, consoles and games)
// every function is given the database connection from dbconn.php


# message that shows once then is removed
function user_message(){
    $message = "";
    if(isset($_SESSION["usermessage"])) {
        $message = $_SESSION["usermessage"];
        unset($_SESSION["usermessage"]);
    }
    return $message;
}

# makes text safe to print on the page
function e($text){
    return htmlspecialchars($text);
}

# if the user is not logged in send them to sign in
function check_login(){
    if (!isset($_SESSION["user_id"])) {
        header("Location: sign_in.php");
        exit;
    }
}

# the regions for the drop down
function region_list(){
    return ["NTSC-U (North America)", "PAL (Europe / UK)", "NTSC-J (Japan)", "Other"];
}



function onlyuser($conn, $email){ // true if nobody has this email yet
    $sql = "SELECT email FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $email);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $conn = null;
    if ($result) {
        return false;
    } else {
        return true;
    }
}

function reg_user($conn){
    $sql = "INSERT INTO users (email, password) VALUES(?,?)";
    $stmt = $conn->prepare($sql);

    $hashed = password_hash($_POST["password"], PASSWORD_DEFAULT); // hash the password

    $stmt->bindParam(1, $_POST["email"]);
    $stmt->bindParam(2, $hashed);

    $stmt->execute();
    $conn = null;
    return true;
}

function login($conn, $email){
    $sql = "SELECT user_id, password FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $email);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $conn = null;
    return $result; // error handle no user
}



function add_user_console($conn, $user_id){
    // the console name is typed in by the user
    $sql = "INSERT INTO user_console (user_id, console_name, region, purchase_date, price) VALUES(?,?,?,?,?)";
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(1, $user_id);
    $stmt->bindParam(2, $_POST["console_name"]);
    $stmt->bindParam(3, $_POST["region"]);
    $stmt->bindParam(4, $_POST["purchase"]);
    $stmt->bindParam(5, $_POST["price"]);

    $stmt->execute();
    $conn = null;
    return true;
}

function get_user_consoles($conn, $user_id){
    // every console owned amd how many
    $sql = "SELECT user_console_id, console_name, region, purchase_date, price,
                   (SELECT COUNT(*) FROM user_game WHERE user_game.user_console_id = user_console.user_console_id) AS game_count
            FROM user_console
            WHERE user_id = ?
            ORDER BY purchase_date DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $user_id);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $conn = null;
    return $result;
}

function remove_user_console($conn, $user_id){
//    removes console from list
    $sql = "DELETE FROM user_console WHERE user_console_id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $_POST["user_console_id"]);
    $stmt->bindParam(2, $user_id);
    $stmt->execute();
    $conn = null;
    return true;
}




function add_user_game($conn, $user_id){
    // the game name is typed in by the user
    $sql = "INSERT INTO user_game (user_id, game_name, user_console_id, purchase_date, price, format) VALUES(?,?,?,?,?,?)";
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(1, $user_id);
    $stmt->bindParam(2, $_POST["game_name"]);
    $stmt->bindParam(3, $_POST["user_console_id"]);
    $stmt->bindParam(4, $_POST["purchase"]);
    $stmt->bindParam(5, $_POST["price"]);
    $stmt->bindParam(6, $_POST["format"]);

    $stmt->execute();
    $conn = null;
    return true;
}

function get_user_games($conn, $user_id, $user_console_id = 0){
    // every game the user owns as according to console
    $sql = "SELECT user_game.user_game_id, user_game.game_name, user_console.console_name, user_console.region,
                   user_game.purchase_date, user_game.price, user_game.format
            FROM user_game
            JOIN user_console ON user_console.user_console_id = user_game.user_console_id
            WHERE user_game.user_id = ?";
    if ($user_console_id > 0) {
        $sql .= " AND user_game.user_console_id = ?";
    }
    $sql .= " ORDER BY user_game.purchase_date DESC";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $user_id);
    if ($user_console_id > 0) {
        $stmt->bindParam(2, $user_console_id);
    }
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $conn = null;
    return $result;
}

function remove_user_game($conn, $user_id){
//  removes game
    $sql = "DELETE FROM user_game WHERE user_game_id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $_POST["user_game_id"]);
    $stmt->bindParam(2, $user_id);
    $stmt->execute();
    $conn = null;
    return true;
}



// stats dashboard may work
function get_stats($conn, $user_id){
    $stats = [];

    $sql = "SELECT COUNT(*) AS total, COALESCE(SUM(price), 0) AS spent, MAX(purchase_date) AS latest
            FROM user_console WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $user_id);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $stats["consoles"] = $row["total"];
    $stats["console_spent"] = $row["spent"];
    $stats["latest_console"] = $row["latest"];

    $sql = "SELECT COUNT(*) AS total, COALESCE(SUM(price), 0) AS spent, MAX(purchase_date) AS latest
            FROM user_game WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $user_id);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $stats["games"] = $row["total"];
    $stats["game_spent"] = $row["spent"];
    $stats["latest_game"] = $row["latest"];

    // how many different regions the consoles come from
    $sql = "SELECT COUNT(DISTINCT region) AS total FROM user_console WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $user_id);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $stats["regions"] = $row["total"];

    $conn = null;
    return $stats;
}
