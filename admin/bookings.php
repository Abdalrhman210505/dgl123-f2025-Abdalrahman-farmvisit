<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}
require_once("../config/db.php");


$stmt = $pdo->query("SELECT * FROM bookings ORDER BY created_at DESC");
$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Bookings</title>
    <link rel="stylesheet" href="../assets/css/admin.css">

</head>

<body>
    <main>
        <h1>Manage Bookings</h1>

        <table>

        <tr>
        <th>ID</th>
        <th>Visitor Name</th>
        <th>Email</th>
        <th>Date</th>
        <th>Time</th>
        <th>Party Size</th>
        <th>Status</th>
        <th>Actions</th>
    </tr>
<?php foreach ($bookings as $b): ?>
 <tr>
        <td><?= $b["booking_id"] ?></td>
        <td><?= htmlspecialchars($b["visitor_name"]) ?></td> <!-- I have used special chars method to protect the page from xos attacks-->
        <td><?= htmlspecialchars($b["email"]) ?></td>
        <td><?= $b["visit_date"] ?></td>
        <td><?= $b["visit_time"] ?></td>
        <td><?= $b["party_size"] ?></td>
        <td><?= $b["status"] ?></td>
        <td>
            <a href="update_booking.php?id=<?= $b["booking_id"] ?>&status=confirmed">Confirm</a> |
            <a href="update_booking.php?id=<?= $b["booking_id"] ?>&status=cancelled">Cancel</a>
        </td>
    </tr>
    <?php endforeach ?>

    
        </table>

        <p><a href="dashboard.php">⬅ Back to Dashboard</a></p>


    </main>
    
</body>
</html>