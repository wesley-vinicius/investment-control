<?php

declare(strict_types=1);

namespace App\Domain\Auth\Action;

use App\Domain\Auth\Repositories\UserRepository;

class LoginAction
{

    public function __construct(
        UserRepository $userRepository
    )
    {
    }

    public function execute(array $credentials)
    {

    }
}
