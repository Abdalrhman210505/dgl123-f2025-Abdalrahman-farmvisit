<?php
use PHPUnit\Framework\TestCase;

class ValidatorsTest extends TestCase
{
    public function testEmailValidation()
    {
        $this->assertTrue(is_email('user@example.com'));
        $this->assertFalse(is_email('invalid-email'));
    }

    public function testLengthBetween()
    {
        $this->assertTrue(len_between('hello', 3, 10));
        $this->assertFalse(len_between('hi', 3, 10));
    }

    public function testDateAndTime()
    {
        $this->assertTrue(is_date('2024-01-01'));
        $this->assertFalse(is_date('2024-13-01'));
        $this->assertTrue(is_time('12:45'));
        $this->assertFalse(is_time('25:00'));
    }

    public function testSafeFilename()
    {
        $this->assertSame('my-file.png', safe_filename('my file.png'));
        $this->assertNull(safe_filename('')); // nothing left after sanitizing
    }
}
