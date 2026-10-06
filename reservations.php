<?php
include "db.php";

$sql = "SELECT * FROM reservations ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reservations</title>

    <link rel="stylesheet" href="style.css">

    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        th {
            background: #333;
            color: white;
        }

        .edit-btn {
            background: green;
            color: white;
            padding: 6px 10px;
            text-decoration: none;
            border-radius: 4px;
        }

        .delete-btn {
            background: red;
            color: white;
            padding: 6px 10px;
            text-decoration: none;
            border-radius: 4px;
        }

        .edit-btn:hover {
            background: darkgreen;
        }

        .delete-btn:hover {
            background: darkred;
        }
    </style>
</head>

<body>

<div class="container">

    <h1>All Reservations</h1>

    <?php if (mysqli_num_rows($result) > 0): ?>

        <table>

            <tr>
                <th>ID</th>
                <th>Guest Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Room</th>
                <th>Check-in</th>
                <th>Check-out</th>
                <th>Guests</th>
                <th>Actions</th>
            </tr>

            <?php while ($row = mysqli_fetch_assoc($result)): ?>

                <tr>

                    <td>
                        <?php echo $row["id"]; ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($row["guest_name"]); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($row["email"]); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($row["phone"]); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($row["room_type"]); ?>
                    </td>

                    <td>
                        <?php echo $row["check_in"]; ?>
                    </td>

                    <td>
                        <?php echo $row["check_out"]; ?>
                    </td>

                    <td>
                        <?php echo $row["guests"]; ?>
                    </td>

                    <td>

                        <a
                            href="edit.php?id=<?php echo $row['id']; ?>"
                            class="edit-btn">
                            Edit
                        </a>

                        <a
                            href="delete.php?id=<?php echo $row['id']; ?>"
                            class="delete-btn"
                            onclick="return confirm('Are you sure you want to delete this reservation?');">
                            Delete
                        </a>

                    </td>

                </tr>

            <?php endwhile; ?>

        </table>

    <?php else: ?>

        <p>No reservations found.</p>

    <?php endif; ?>

    <br>

    <a href="book.php" class="btn">
        Make New Reservation
    </a>

    <a href="index.php" class="btn">
        Back to Home
    </a>

</div>

</body>
</html>
