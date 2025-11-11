<?php
use PHPUnit\Framework\TestCase;

class AuthTest extends TestCase
{
    private PDO $pdo;

    protected function setUp(): void
    {
        $this->pdo = new PDO('sqlite::memory:');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->exec('CREATE TABLE users (user_id INTEGER PRIMARY KEY AUTOINCREMENT, full_name TEXT, email TEXT, username TEXT UNIQUE, password_hash TEXT, role TEXT)');
        setPDO($this->pdo);
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION = [];
    }

    public function testRegisterUserCreatesAccount()
    {
        $result = register_user([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'username' => 'admin',
            'password' => 'secretpass',
            'confirm_password' => 'secretpass',
        ]);

        $this->assertArrayHasKey('user_id', $result);
        $stmt = $this->pdo->query('SELECT * FROM users WHERE username = "admin"');
        $row = $stmt->fetch();
        $this->assertNotFalse($row);
        $this->assertTrue(password_verify('secretpass', $row['password_hash']));
    }

    public function testLoginUserSuccessAndFailure()
    {
        $hash = password_hash('pass1234', PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare('INSERT INTO users (full_name, email, username, password_hash, role) VALUES (?, ?, ?, ?, ?)');
        $stmt->execute(['User', 'user@example.com', 'user', $hash, 'admin']);

        $this->assertTrue(login_user('user', 'pass1234'));
        $this->assertFalse(login_user('user', 'wrong'));
    }
}
