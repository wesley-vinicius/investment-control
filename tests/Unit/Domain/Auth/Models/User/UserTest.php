<?php

namespace Tests\Unit\Domain\Auth\Models\User;

use App\Domain\Auth\Models\User;
use App\Domain\Wallet\Models\Wallet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class UserTest extends TestCase
{

    use RefreshDatabase;
    
    public function setUp(): void
    {
        parent::setUp();
    }

    public function testUsersDatabaseHasExpectedColumns()
    {
        $this->assertTrue( 
          Schema::hasColumns('users', [
            'id','name', 'email', 'email_verified_at', 'password'
        ]), 1);
    }

    public function testUserHasWallet()
    {
        $user = User::factory()->create();
        $wallet = Wallet::find(1);

        $this->assertTrue($user->wallet->contains($wallet));
        $this->assertEquals(1, $user->wallet->count());
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $user->wallet);
    }

    public function testUserHasTwoWallet()
    {
        $user = User::factory()->create();
        $wallet = Wallet::factory()->create(['user_id' => $user->id]);

        $this->assertTrue($user->wallet->contains($wallet));
        $this->assertEquals(2, $user->wallet->count());
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $user->wallet);
    }

}
