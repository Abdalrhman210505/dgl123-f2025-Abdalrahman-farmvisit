<?php
/**
 * Allows admins to view and edit farm hours.
 */

$pageTitle = 'Farm Hours';
require_once __DIR__ . '/includes/header.php';

$hours = [];
$days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

try {
    $stmt = $pdo->query('SELECT * FROM farm_hours ORDER BY day_of_week ASC');
    $hours = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    set_flash('error', 'Unable to load hours: ' . $e->getMessage());
}
?>
<h1>Manage Farm Hours</h1>

<form class="form hours-page-form" method="POST" action="save_hours.php">
    <table class="hours-table">
        <tr>
            <th>Day</th>
            <th>Open Time</th>
            <th>Close Time</th>
            <th>Closed?</th>
            <th>Notes</th>
        </tr>

        <?php foreach ($hours as $hour): ?>
            <tr>
                <td><?= $days[$hour['day_of_week']] ?></td>
                <td>
                    <input type="time" name="open_time[<?= $hour['day_of_week'] ?>]" value="<?= $hour['open_time'] ?>">
                </td>
                <td>
                    <input type="time" name="close_time[<?= $hour['day_of_week'] ?>]" value="<?= $hour['close_time'] ?>">
                </td>
                <td>
                    <input type="checkbox" name="is_closed[<?= $hour['day_of_week'] ?>]" value="1" <?= $hour['is_closed'] ? 'checked' : '' ?>>
                </td>
                <td>
                    <input type="text" name="notes[<?= $hour['day_of_week'] ?>]" value="<?= sanitize_text($hour['notes']) ?>">
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <br>
    <button type="submit">Save Changes</button>
</form>

<p><a href="dashboard.php"> <- Back to Dashboard</a></p>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
