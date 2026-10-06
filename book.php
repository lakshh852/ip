<?php
include "db.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $guest_name = $_POST["guest_name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $room_type = $_POST["room_type"];
    $check_in = $_POST["check_in"];
    $check_out = $_POST["check_out"];
    $guests = $_POST["guests"];

    $sql = "INSERT INTO reservations 
            (guest_name, email, phone, room_type, check_in, check_out, guests)
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "ssssssi",
        $guest_name,
        $email,
        $phone,
        $room_type,
        $check_in,
        $check_out,
        $guests
    );

    if (mysqli_stmt_execute($stmt)) {
        $message = "Reservation successful!";
    } else {
        $message = "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Make a Reservation</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

    <h1>Make a Reservation</h1>

    <?php if ($message != ""): ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>

    <form method="POST">

        <p>
            <input type="text" name="guest_name"
                   placeholder="Guest Name" required>
        </p>

        <p>
            <input type="email" name="email"
                   placeholder="Email" required>
        </p>

        <p>
            <input type="text" name="phone"
                   placeholder="Phone Number" required>
        </p>

        <p>
            <select name="room_type" required>
                <option value="">Select Room Type</option>
                <option value="Single">Single Room</option>
                <option value="Double">Double Room</option>
                <option value="Deluxe">Deluxe Room</option>
                <option value="Suite">Suite</option>
            </select>
        </p>

        <p>
            <label>Check-in:</label><br>
            <input type="date" name="check_in" required>
        </p>

        <p>
            <label>Check-out:</label><br>
            <input type="date" name="check_out" required>
        </p>

        <p>
            <input type="number" name="guests"
                   placeholder="Number of Guests"
                   min="1" required>
        </p>

        <button type="submit" class="btn">
            Reserve Now
        </button>

    </form>

    <br>

    <a href="index.php" class="btn">Back to Home</a>

</div>

</body>
</html>