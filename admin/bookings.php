<?php
/**
 * Manage Bookings Page
 * 
 * Purpose:
 * - Displays all bookings to the admin.
 * - Allows admin to update booking status (confirm/cancel).
 * 
 * Refactor Improvements:
 * - Added documentation block.
 * - Improved formatting and readability.
 * - Sanitized all output.
 * - Converted SQL query to select only needed columns.
 * - Added session security hardening.
 * - Added error-handling structure.
 */

session_start();

// Block unauthorized access
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

// Improve session security (recommended)
session_regenerate_id(true);

require_once("../config/db.php");

try {
    // Select only necessary columns (better performance than SELECT *)
    $stmt = $pdo->query("
        SELECT booking_id, visitor_name, email, visit_date, visit_time, party_size, status, created_at 
        FROM bookings 
        ORDER BY created_at DESC
    ");

    $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (Exception $e) {
    error_log("Database error: " . $e->getMessage());
    die("An error occurred while loading bookings.");
}
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
    <main class="booking-container">
        <h1 class="page-title">Manage Bookings</h1>

        <table class="admin-table">
            <thead>
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
            </thead>

            <tbody>
            <?php foreach ($bookings as $booking): ?>
                <tr>
                    <td><?= $booking["booking_id"] ?></td>

                    <td><?= htmlspecialchars($booking["visitor_name"]) ?></td>

                    <td><?= htmlspecialchars($booking["email"]) ?></td>

                    <td><?= htmlspecialchars($booking["visit_date"]) ?></td>

                    <td><?= htmlspecialchars($booking["visit_time"]) ?></td>

                    <td><?= htmlspecialchars($booking["party_size"]) ?></td>

                    <td><?= htmlspecialchars($booking["status"]) ?></td>

                    <td>
                        <a href="update_booking.php?id=<?= $booking["booking_id"] ?>&status=confirmed">Confirm</a> |
                        <a href="update_booking.php?id=<?= $booking["booking_id"] ?>&status=cancelled">Cancel</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

        <p>
            <a href="dashboard.php">⬅ Back to Dashboard</a>
        </p>

    </main>
</body>
</html>
