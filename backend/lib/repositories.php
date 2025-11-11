<?php
require_once __DIR__ . '/db.php';

// Users repository
function findUserByUsername(string $username): ?array
{
    $pdo = getPDO();
    $stmt = $pdo->prepare('SELECT user_id AS id, username, password_hash, email, full_name AS name, role FROM users WHERE username = :username LIMIT 1');
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch();
    return $user ?: null;
}

function findUserById(int $id): ?array
{
    $pdo = getPDO();
    $stmt = $pdo->prepare('SELECT user_id AS id, username, password_hash, email, full_name AS name, role FROM users WHERE user_id = :id LIMIT 1');
    $stmt->execute(['id' => $id]);
    $user = $stmt->fetch();
    return $user ?: null;
}

function createUser(array $data): int
{
    $pdo = getPDO();
    $stmt = $pdo->prepare('INSERT INTO users (full_name, email, username, password_hash, role) VALUES (:full_name, :email, :username, :password_hash, :role)');
    $stmt->execute([
        'full_name' => $data['name'],
        'email' => $data['email'],
        'username' => $data['username'],
        'password_hash' => $data['password_hash'],
        'role' => $data['role'] ?? 'staff',
    ]);
    return (int)$pdo->lastInsertId();
}

// Bookings repository
function createBooking(array $data): int
{
    $pdo = getPDO();
    $stmt = $pdo->prepare('INSERT INTO bookings (visitor_name, email, phone, visit_date, visit_time, party_size, notes, status) VALUES (:visitor_name, :email, :phone, :visit_date, :visit_time, :party_size, :notes, :status)');
    $stmt->execute([
        'visitor_name' => $data['name'],
        'email' => $data['email'],
        'phone' => $data['phone'] ?? null,
        'visit_date' => $data['visit_date'] ?? null,
        'visit_time' => $data['visit_time'] ?? null,
        'party_size' => $data['guests'] ?? null,
        'notes' => $data['message'] ?? null,
        'status' => $data['status'] ?? 'new',
    ]);
    return (int)$pdo->lastInsertId();
}

function listBookings(?string $status = null): array
{
    $pdo = getPDO();
    if ($status) {
        $stmt = $pdo->prepare('SELECT booking_id AS id, visitor_name AS name, email, phone, visit_date, visit_time, party_size AS guests, notes, status, created_at FROM bookings WHERE status = :status ORDER BY created_at DESC');
        $stmt->execute(['status' => $status]);
        return $stmt->fetchAll();
    }
    $stmt = $pdo->query('SELECT booking_id AS id, visitor_name AS name, email, phone, visit_date, visit_time, party_size AS guests, notes, status, created_at FROM bookings ORDER BY created_at DESC');
    return $stmt->fetchAll();
}

function updateBookingStatus(int $id, string $status): bool
{
    $pdo = getPDO();
    $stmt = $pdo->prepare('UPDATE bookings SET status = :status WHERE booking_id = :id');
    $stmt->execute(['status' => $status, 'id' => $id]);
    return $stmt->rowCount() > 0;
}

function deleteBooking(int $id): bool
{
    $pdo = getPDO();
    $stmt = $pdo->prepare('DELETE FROM bookings WHERE booking_id = :id');
    $stmt->execute(['id' => $id]);
    return $stmt->rowCount() > 0;
}

// Gallery repository
function createImage(array $data): int
{
    $pdo = getPDO();
    $stmt = $pdo->prepare('INSERT INTO gallery_images (file_name, caption, is_public, uploaded_by) VALUES (:file_name, :caption, :is_public, :uploaded_by)');
    $stmt->execute([
        'file_name' => $data['filename'],
        'caption' => $data['caption'] ?? null,
        'is_public' => $data['is_public'] ?? 1,
        'uploaded_by' => $data['uploaded_by'] ?? null,
    ]);
    return (int)$pdo->lastInsertId();
}

function listImages(bool $publicOnly = false): array
{
    $pdo = getPDO();
    if ($publicOnly) {
        $stmt = $pdo->prepare('SELECT image_id AS id, file_name AS filename, caption, is_public, uploaded_by, uploaded_at FROM gallery_images WHERE is_public = 1 ORDER BY uploaded_at DESC');
        $stmt->execute();
        return $stmt->fetchAll();
    }
    $stmt = $pdo->query('SELECT image_id AS id, file_name AS filename, caption, is_public, uploaded_by, uploaded_at FROM gallery_images ORDER BY uploaded_at DESC');
    return $stmt->fetchAll();
}

function updateImage(int $id, string $caption, int $is_public): bool
{
    $pdo = getPDO();
    $stmt = $pdo->prepare('UPDATE gallery_images SET caption = :caption, is_public = :is_public WHERE image_id = :id');
    $stmt->execute([
        'caption' => $caption,
        'is_public' => $is_public,
        'id' => $id,
    ]);
    return $stmt->rowCount() > 0;
}

function deleteImage(int $id): ?array
{
    $pdo = getPDO();
    $stmt = $pdo->prepare('SELECT image_id AS id, file_name AS filename FROM gallery_images WHERE image_id = :id');
    $stmt->execute(['id' => $id]);
    $image = $stmt->fetch();
    if (!$image) {
        return null;
    }
    $delStmt = $pdo->prepare('DELETE FROM gallery_images WHERE image_id = :id');
    $delStmt->execute(['id' => $id]);
    return $image;
}

// Hours repository
function getHours(): array
{
    $pdo = getPDO();
    $stmt = $pdo->query('SELECT day_of_week, open_time, close_time, notes, is_closed FROM farm_hours ORDER BY day_of_week');
    return $stmt->fetchAll();
}

function saveHours(array $rows): void
{
    $pdo = getPDO();
    $pdo->beginTransaction();
    try {
        $stmt = $pdo->prepare('REPLACE INTO farm_hours (day_of_week, open_time, close_time, is_closed, notes) VALUES (:day_of_week, :open_time, :close_time, :is_closed, :notes)');
        foreach ($rows as $row) {
            $stmt->execute([
                'day_of_week' => $row['day_of_week'],
                'open_time' => $row['open_time'],
                'close_time' => $row['close_time'],
                'is_closed' => $row['is_closed'],
                'notes' => $row['notes'],
            ]);
        }
        $pdo->commit();
    } catch (Throwable $e) {
        $pdo->rollBack();
        throw $e;
    }
}
