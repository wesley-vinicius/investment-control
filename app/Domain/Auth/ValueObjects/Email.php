<?php

declare(strict_types=1);

namespace App\Domain\Auth\ValueObjects;

class Email implements \Stringable
{
    private string $address;

    public function __construct(string $address)
    {
        if (filter_var($address, FILTER_VALIDATE_EMAIL) === false) {
            throw new \InvalidArgumentException(
                'Endereço de e-mail inválido'
            );
        }

        $this->address = $address;
    }

    public function __toString(): string
    {
        return $this->address;
    }
}
