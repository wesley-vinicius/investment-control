<?php

namespace Tests\Unit\Domain\Auth\ValueObjects;

use App\Domain\Auth\ValueObjects\Email;
use Tests\TestCase;

class EmailTest extends TestCase
{
    public function testEmailInvalidExpectedException()
    {
        $this->expectException(\InvalidArgumentException::class);
        new Email('email invalid');
    }

    public function testEmailValid()
    {
        $email = new Email('test@email.com');
        $this->assertInstanceOf(Email::class, $email);
        $this->assertSame('test@email.com', (string) $email);
    }
}
