<?php
session_start();
require_once "dbconn.php";
require_once "user_common.php";

check_login();
$patient = get_patient(dbconnect_insert(), $_SESSION["patient_id"]);
$appointments = appt_getter(dbconnect_insert(), $_SESSION["patient_id"]);
$message = user_message();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    remove_booking(dbconnect_insert());
    $_SESSION["usermessage"] = "booking removed from your collection.";
    header("Location: book.php");
    exit;
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>bookings</title>
    <link rel="stylesheet" href="assets/styles.css">

</head>

<body>
<div class="navi">
    <?php require_once "navi.php"; ?>
    <div class="register_bar">
        <h1>Your bookings</h1>
        <p>Welcome <?php echo e($patient["firstname"] . " " . $patient["surname"]); ?></p>
        <?php if ($message !== "") { echo '<p class="message">' . e($message) . '</p>'; } ?>

        <?php if (count($appointments) == 0) { ?>
            <p>You have no bookings yet.</p>
        <?php } else { ?>
            <table>
                <tr>
                    <th>Date and time</th>
                    <th>Doctor</th>
                    <th>Field</th>
                    <th>Details</th>
                    <th>remove</th>

                </tr>
                <?php foreach ($appointments as $a) { ?>
                    <tr>
                        <td><?php echo e($a["appointment_booking"]); ?></td>
                        <td><?php echo e($a["doctor_name"]); ?></td>
                        <td><?php echo e($a["field_of_work"]); ?></td>
                        <td><?php echo e($a["appointment_details"]); ?></td>

                    <td>
                        <form method="post">
                            <input type="hidden" name="booking_id" value="<?php echo e($a["booking_id"]); ?>">
                            <button type="submit" class="remove_btn">Remove</button>
                        </form>
                    </td>
                    </tr>
                <?php } ?>
            </table>
        <?php } ?>
    </div>
</div>
</body>
</html>
