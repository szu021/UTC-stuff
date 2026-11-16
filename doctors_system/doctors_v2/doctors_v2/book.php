<?php
session_start();
require_once "dbconn.php";
require_once "user_common.php";

check_login();
$conn = dbconnect_insert();
$patient = get_patient($conn, $_SESSION["patient_id"]);

// only try to book when the form has actually been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        if (make_booking($conn)) {
            $_SESSION["usermessage"] = "Your booking was successful!";
        } else {
            $_SESSION["usermessage"] = "Your booking has failed.";
        }
    } catch (Exception $e) {
        $_SESSION["usermessage"] = "Your booking has failed: " . $e->getMessage();
    }
    header("Location: bookings.php");
    exit;
}

$doctors = doc_getter(dbconnect_insert());
?>

<!DOCTYPE html>
<html>

<head>
    <title>appointment booking</title>
    <link rel="stylesheet" href="assets/styles.css">

</head>

<body>
<div class="navi">
    <?php require_once "navi.php"; ?>
    <div class="register_bar">
        <h1>Book an appointment</h1>
        <p>Welcome <?php echo e($patient["firstname"] . " " . $patient["surname"]); ?></p>

        <form action="" method="post">
            <label for="appt-time">choose a time</label>
            <input
                    type="datetime-local"
                    id="appt-time"
                    name="appt-time"
                    required
            />
            <br>
            <label for="doctor_id">choose a doctor</label>
            <select name="doctor_id" id="doctor_id" required>
                <?php
                foreach ($doctors as $d) {
                    echo "<option value='" . e($d["doctor_ID"]) . "'>" . e($d["name"]) . "</option>";
                }
                ?>
            </select>
            <br>
            <label for="details">state appointment details</label>
            <textarea name="details" id="details" rows="4" placeholder="Reason for appointment"></textarea>
            <button type="submit">
                Submit
            </button>
        </form>

    </div>
</div>

</body>
</html>
