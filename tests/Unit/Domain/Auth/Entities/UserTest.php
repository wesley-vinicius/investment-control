<?php

namespace Tests\Unit\Domain\Auth\Entities;

use App\Domain\Auth\Entities\User;

use Tests\TestCase;

class UserTest extends TestCase
{

    public function testEntitiesUserConstruct()
    {
        $data = [
            'name' => 'name test',
            'email' => 'email@test.com',
            'password' => 'password'
        ];

        $user = User::create($data);
        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals([
            'name' => 'name test',
            'email' => 'email@test.com',
            'password' => 'password'
        ], $user->toArray());
    }
}
