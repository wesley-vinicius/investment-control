<?php

declare(strict_types=1);

namespace App\Domain\Auth\ValueObjects;

use Illuminate\Support\Facades\Hash;

class Password
{
    private string $password;

    public function __construct(string $password)
    {
        $this->validate($password);
        $this->password = Hash::make($password);
    }

    public static function fromString(string $password): self
    {
        return new self($password);
    }

    private function validate(string $password)
    {
        if (strlen($password) < 8) {
            throw new \InvalidArgumentException(
                'Senha inválida'
            );
        }
    }

    public function __toString(): string
    {
        return $this->password;
    }

}
