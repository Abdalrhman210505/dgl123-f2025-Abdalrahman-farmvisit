<?php
use PHPUnit\Framework\TestCase;

class RepositoriesTest extends TestCase
{
    private PDO $pdo;

    protected function setUp(): void
    {
        $this->pdo = new PDO('sqlite::memory:');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->exec('CREATE TABLE bookings (booking_id INTEGER PRIMARY KEY AUTOINCREMENT, visitor_name TEXT, email TEXT, phone TEXT, visit_date TEXT, visit_time TEXT, party_size INTEGER, notes TEXT, status TEXT, created_at TEXT DEFAULT CURRENT_TIMESTAMP)');
        setPDO($this->pdo);
    }

    public function testBookingCrud()
    {
        $bookingId = createBooking([
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'visit_date' => '2024-05-01',
            'visit_time' => '10:30',
            'guests' => 4,
            'message' => 'Looking forward!',
            'status' => 'new',
        ]);
        $this->assertGreaterThan(0, $bookingId);

        $bookings = listBookings();
        $this->assertCount(1, $bookings);
        $this->assertSame('Jane Doe', $bookings[0]['name']);

        $this->assertTrue(updateBookingStatus($bookingId, 'confirmed'));
        $bookings = listBookings('confirmed');
        $this->assertCount(1, $bookings);
        $this->assertSame('confirmed', $bookings[0]['status']);

        $this->assertTrue(deleteBooking($bookingId));
        $bookings = listBookings();
        $this->assertCount(0, $bookings);
    }
}
