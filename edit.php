<?php
include "db.php";

if (!isset($_GET["id"])) {
    die("Reservation ID not found.");
}

$id = $_GET["id"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $guest_name = $_POST["guest_name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $room_type = $_POST["room_type"];
    $check_in = $_POST["check_in"];
    $check_out = $_POST["check_out"];
    $guests = $_POST["guests"];

    $sql = "UPDATE reservations SET
            guest_name = ?,
            email = ?,
            phone = ?,
            room_type = ?,
            check_in = ?,
            check_out = ?,
            guests = ?
            WHERE id = ?";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "ssssssii",
        $guest_name,
        $email,
        $phone,
        $room_type,
        $check_in,
        $check_out,
        $guests,
        $id
    );

    if (mysqli_stmt_execute($stmt)) {
        header("Location: reservations.php");
        exit;
    } else {
        echo "Error updating reservation: " . mysqli_error($conn);
    }
}

$sql = "SELECT * FROM reservations WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$reservation = mysqli_fetch_assoc($result);

if (!$reservation) {
    die("Reservation not found.");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Reservation</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container">

    <h1>Edit Reservation</h1>

    <form method="POST">

        <p>
            <input
                type="text"
                name="guest_name"
                value="<?php echo htmlspecialchars($reservation['guest_name']); ?>"
                placeholder="Guest Name"
                required>
        </p>

        <p>
            <input
                type="email"
                name="email"
                value="<?php echo htmlspecialchars($reservation['email']); ?>"
                placeholder="Email"
                required>
        </p>

        <p>
            <input
                type="text"
                name="phone"
                value="<?php echo htmlspecialchars($reservation['phone']); ?>"
                placeholder="Phone Number"
                required>
        </p>

        <p>
            <select name="room_type" required>

                <option value="">Select Room Type</option>

                <option value="Single"
                    <?php if ($reservation['room_type'] == 'Single') echo 'selected'; ?>>
                    Single Room
                </option>

                <option value="Double"
                    <?php if ($reservation['room_type'] == 'Double') echo 'selected'; ?>>
                    Double Room
                </option>

                <option value="Deluxe"
                    <?php if ($reservation['room_type'] == 'Deluxe') echo 'selected'; ?>>
                    Deluxe Room
                </option>

                <option value="Suite"
                    <?php if ($reservation['room_type'] == 'Suite') echo 'selected'; ?>>
                    Suite
                </option>

            </select>
        </p>

        <p>
            <label>Check-in:</label><br>
            <input
                type="date"
                name="check_in"
                value="<?php echo $reservation['check_in']; ?>"
                required>
        </p>

        <p>
            <label>Check-out:</label><br>
            <input
                type="date"
                name="check_out"
                value="<?php echo $reservation['check_out']; ?>"
                required>
        </p>

        <p>
            <input
                type="number"
                name="guests"
                value="<?php echo $reservation['guests']; ?>"
                min="1"
                placeholder="Number of Guests"
                required>
        </p>

        <button type="submit" class="btn">
            Update Reservation
        </button>

    </form>

    <br>

    <a href="reservations.php" class="btn">
        Back to Reservations
    </a>

</div>

</body>
</html>
