<?php

namespace App\Domain\Auth\Entities;

use App\Domain\Auth\ValueObjects\Password;
use JetBrains\PhpStorm\ArrayShape;
use App\Domain\Auth\ValueObjects\Email;

class User
{

    /**
     * User constructor.
     * @param string $name
     * @param Email $email
     * @param Password $password
     */
    public function __construct(
        private string $name,
        private Email $email,
        private Password $password
    )
    {
    }

    /**
     * @param array $data
     * @return static
     */
    public static function create(array $data): self
    {
        return new self(
            name: $data['name'],
            email: new Email($data['email']),
            password: $data['password'],
        );
    }

    /**
     * @return array
     */
    #[ArrayShape(['name' => "string", 'email' => "\App\Domain\Auth\ValueObjects\Email", 'password' => "string"])]
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password
        ];
    }
}
