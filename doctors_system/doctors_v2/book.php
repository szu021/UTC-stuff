<?php
session_start();
require_once "dbconn.php";
require_once "user_common.php";

check_login();
$patient = get_patient(dbconnect_insert(), $_SESSION["patient_id"]);
try {

    if (make_booking(dbconnect_insert())) {
        $_SESSION["usermessage"] = "Your booking has failed";
        header("Location: bookings.php");
        exit;
    } else {
        $_SESSION["usermessage"] = "Your booking has failed";
        header("Location: bookings.php");
        exit;
    }
} catch (PDOException $e) {
    $_SESSION["usermessage"] = "Your booking has failed" . $e->getMessage();
    header("Location: bookings.php");
}
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
            <label for="appt time">choose a time</label>

            <input
                    type="datetime-local"
                    id="appt-time"
                    name="appt-time"
            />
            <label for="doctor">choose a doctor</label>

            <br>
            <select name ="doctor">
                <?php
                $doc =doc_getter(dbconnect_insert());
                foreach ($doc as $d) {
                    echo "<option value='" . $d["doctor_ID"] . "'>" . $d["name"] . "</option>";
                }
                ?>

            </select>
            <label for="deets">state appointment details</label>
            <button type="submit">
                Submit
            </button>
        </form>

    </div>
</div>



</body>
</html>

