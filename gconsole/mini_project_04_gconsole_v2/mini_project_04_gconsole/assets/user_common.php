<?php



# user message
function user_message(){
    $message = "";
    if(isset($_SESSION["usermessage"])) {
        $message = $_SESSION["usermessage"];
        unset($_SESSION["usermessage"]);
    }
    return $message;
}


function e($text){
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}


function check_login(){
    if (!isset($_SESSION["user_id"])) {
        $_SESSION["usermessage"] = "Please sign in first.";
        header("Location: sign_in.php");
        exit;
    }
}


function region_list(){
    return ["NTSC-U (North America)", "PAL (Europe / UK)", "NTSC-J (Japan)", "Other"];
}


function valid_date($date){
    $d = DateTime::createFromFormat("Y-m-d", $date);
    if (!$d || $d->format("Y-m-d") !== $date) {
        return false;
    }
    return $d <= new DateTime("today");
}


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

# get user id
function getuserid($conn, $email){
    $sql = "SELECT user_id FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $email);
    $stmt->execute(); // run sql
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $conn = null;
    return $result["user_id"];
}






function get_games($conn){

    $sql = "SELECT game_id, name FROM game ORDER BY name";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $conn = null;
    return $result;
}



function add_user_console($conn, $user_id){

    $sql = "SELECT console_id FROM console WHERE console_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $_POST["console_id"]);
    $stmt->execute();
    if (!$stmt->fetch(PDO::FETCH_ASSOC)) {
        $conn = null;
        return false;
    }

    $sql = "INSERT INTO user_console (user_id, console_id, region, purchase_date, price) VALUES(?,?,?,?,?)";
    $stmt = $conn->prepare($sql);


    $stmt->bindParam(1, $user_id);
    $stmt->bindParam(2, $_POST["console_id"]);
    $stmt->bindParam(3, $_POST["region"]);
    $stmt->bindParam(4, $_POST["purchase"]);
    $stmt->bindParam(5, $_POST["price"]);

    $stmt->execute(); // run sql
    $conn = null;
    return true;
}

function get_user_consoles($conn, $user_id){

    $sql = "SELECT uc.user_console_id, c.console_name, uc.region, uc.purchase_date, uc.price,
                   (SELECT COUNT(*) FROM user_game ug WHERE ug.user_console_id = uc.user_console_id) AS game_count


            FROM user_console uc
            JOIN console c ON c.console_id = uc.console_id
            WHERE uc.user_id = ?
            ORDER BY uc.purchase_date DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $user_id);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $conn = null;
    return $result;
}

function remove_user_console($conn, $user_id){

    $sql = "DELETE FROM user_console WHERE user_console_id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $_POST["user_console_id"]);
    $stmt->bindParam(2, $user_id);
    $stmt->execute();
    $removed = $stmt->rowCount();
    $conn = null;
    return $removed > 0;
}




function add_user_game($conn, $user_id){

    $sql = "SELECT user_console_id FROM user_console WHERE user_console_id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $_POST["user_console_id"]);
    $stmt->bindParam(2, $user_id);

    $stmt->execute();
    if (!$stmt->fetch(PDO::FETCH_ASSOC)) {
        $conn = null;
        return "That console is not in your collection.";
    }


    $sql = "SELECT game_id FROM game WHERE game_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $_POST["game_id"]);
    $stmt->execute();
    if (!$stmt->fetch(PDO::FETCH_ASSOC)) {
        $conn = null;
        return "That game does not exist.";
    }


    $sql = "SELECT user_game_id FROM user_game WHERE user_id = ? AND game_id = ? AND user_console_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $user_id);
    $stmt->bindParam(2, $_POST["game_id"]);
    $stmt->bindParam(3, $_POST["user_console_id"]);
    $stmt->execute();
    if ($stmt->fetch(PDO::FETCH_ASSOC)) {
        $conn = null;
        return "You already own that game on that console.";
    }

    $sql = "INSERT INTO user_game (user_id, game_id, user_console_id, purchase_date, price, format) VALUES(?,?,?,?,?,?)";
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(1, $user_id);
    $stmt->bindParam(2, $_POST["game_id"]);
    $stmt->bindParam(3, $_POST["user_console_id"]);
    $stmt->bindParam(4, $_POST["purchase"]);
    $stmt->bindParam(5, $_POST["price"]);
    $stmt->bindParam(6, $_POST["format"]);

    $stmt->execute();
    $conn = null;
    return true;
}

function get_user_games($conn, $user_id, $user_console_id = 0){

    $sql = "SELECT ug.user_game_id, g.name AS game_name, c.console_name, uc.region,
                   ug.purchase_date, ug.price, ug.format
            FROM user_game ug
            JOIN game g ON g.game_id = ug.game_id
            JOIN user_console uc ON uc.user_console_id = ug.user_console_id
            JOIN console c ON c.console_id = uc.console_id
            WHERE ug.user_id = ?";
    if ($user_console_id > 0) {
        $sql .= " AND ug.user_console_id = ?";
    }
    $sql .= " ORDER BY ug.purchase_date DESC";

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

    $sql = "DELETE FROM user_game WHERE user_game_id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $_POST["user_game_id"]);
    $stmt->bindParam(2, $user_id);
    $stmt->execute();
    $removed = $stmt->rowCount();
    $conn = null;
    return $removed > 0;
}



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
