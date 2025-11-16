<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}
require_once("../config/db.php");

// fethcing farm hours
$stmt = $pdo -> query("SELECT * FROM farm_hours ORDER BY day_of_week ASC");
$hours = $stmt -> fetchAll(PDO::FETCH_ASSOC);
// label
$days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farm Hours</title>
</head>
<body>
   <main>
<h1>Manage Farm Hours</h1>

<form method="POST" action="save_hours.php">
<table>
    <tr>
        <th>Day</th>
        <th>Open Time</th>
        <th>Close Time</th>
        <th>Closed?</th>
        <th>Notes</th>
    </tr>

    <?php foreach ($hours as $h): ?>
    <tr>
        <td><?= $days[$h["day_of_week"]] ?></td> <!-- the week day -->
        <td>
            <input type="time" name="open_time[<?= $h["day_of_week"] ?>]" 
                   value="<?= $h["open_time"] ?>">
        </td>

        <td>
            <input type="time" name="close_time[<?= $h["day_of_week"] ?>]" 
                   value="<?= $h["close_time"] ?>">
        </td>

        <td>
            <input type="checkbox" name="is_closed[<?= $h["day_of_week"] ?>]" 
                   value="1" <?= $h["is_closed"] ? "checked" : "" ?>>
        </td>

        <td>
            <input type="text" name="notes[<?= $h["day_of_week"] ?>]" 
                   value="<?= htmlspecialchars($h["notes"]) ?>">
        </td>
    </tr>
    <?php endforeach; ?>

</table>

<br>
<button type="submit">Save Changes</button>
</form>

<p><a href="dashboard.php"> <- Back to Dashboard</a></p>
</main>
</body>
</html>