<?php
function dbconnect_insert()
{
    $servername = "127.0.0.1";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "doctors_surgery";

    $conn = new PDO("mysql:host=$servername;port=3306;dbname=$dbname", $dbusername, $dbpassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $conn;
}


function doc_getter($conn)
{
    $sql = "SELECT * FROM doctors";

    $stmt = $conn->prepare($sql);

    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $conn = null;
    return $result;
}

function make_booking($conn)
{
    if (empty($_POST["appt-time"]) || empty($_POST["doctor_id"])) {
        throw new InvalidArgumentException("Missing required booking details.");
    }

    $dt = new DateTime($_POST["appt-time"]);
    if ($dt <= new DateTime()) {
        throw new InvalidArgumentException("Please choose a time in the future.");
    }
    $mysql_datetime = $dt->format("Y-m-d H:i:s");
    $details = trim($_POST["details"] ?? "");
    $doctor_id = (int) $_POST["doctor_id"];
    $patient_id = (int) $_SESSION["patient_id"];

    // stop two bookings for the same doctor at the same time
    $check = $conn->prepare("SELECT COUNT(*) FROM booking WHERE doctor_id = ? AND appointment_booking = ?");
    $check->bindParam(1, $doctor_id);
    $check->bindParam(2, $mysql_datetime);
    $check->execute();
    if ($check->fetchColumn() > 0) {
        throw new InvalidArgumentException("That doctor is already booked at that time.");
    }

    $sql = "INSERT INTO booking (appointment_booking, appointment_details, doctor_id, patient_id)
            VALUES (?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $mysql_datetime);
    $stmt->bindParam(2, $details);
    $stmt->bindParam(3, $doctor_id);
    $stmt->bindParam(4, $patient_id);

    return $stmt->execute();
}


function appt_getter($conn, $patient_id)
{
    $sql = "SELECT b.booking_id, b.appointment_booking, b.appointment_details, d.name AS doctor_name, d.field_of_work
            FROM booking b
            JOIN doctors d ON d.doctor_ID = b.doctor_id
            WHERE b.patient_id = ?
            ORDER BY b.appointment_booking ASC";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $patient_id);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $conn = null;
    return $result;
}
