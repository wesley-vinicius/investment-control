<?php

namespace Tests\Feature\Domain\Wallet\Http\Controllers;

use Illuminate\Support\Str;
use App\Domain\Auth\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class CreateWalletTest extends TestCase
{
    use DatabaseMigrations;
    
    public function setUp(): void
    {
        parent::setUp();
    
        Sanctum::actingAs(
            User::factory()->create()
        );
    }

    /**
     * @dataProvider getNameFieldCreateWalletFailureScenarios
     * @dataProvider getDescriptionFieldCreateWalletFailureScenarios
     */
    public function testMustFailCreateWalletAttemptWithoutCorrectData(array $payload, $expected)
    {
        $response = $this->postJson(
            route('wallet.create'),
            $payload
        );

        $response->assertStatus($expected['status_code']);
        $response->assertJsonValidationErrors($expected['validationErrors']);
    }

    /**
     * @dataProvider getCreateWalletSuccessScenarios
     */
    public function testCreateWallet(array $payload)
    {
        $user = User::find(1);
    
        $response = $this->postJson(
            route('wallet.create'), 
        $payload);

        $response->assertStatus(Response::HTTP_CREATED);
        $this->assertDatabaseHas('wallets', [
            'name' => $payload['name'],
            'description' => $payload['description'],
            'user_id' => $user->id
        ]);
    }

    public function getNameFieldCreateWalletFailureScenarios()
    {
        return [
            [
                'payload' => [
                    'description' => Str::random(100)

                ],
                'expected' => [
                    'status_code' => Response::HTTP_UNPROCESSABLE_ENTITY,
                    'validationErrors' => ['name'],
                ]
            ],
            [
                'payload' => [
                    'name' => rand(0, 1000),
                    'description' => Str::random(100)

                ],
                'expected' => [
                    'status_code' => Response::HTTP_UNPROCESSABLE_ENTITY,
                    'validationErrors' => ['name'],
                ]
            ],
            [
                'payload' => [
                    'name' => Str::random(256),
                    'description' => Str::random(100)

                ],
                'expected' => [
                    'status_code' => Response::HTTP_UNPROCESSABLE_ENTITY,
                    'validationErrors' => ['name'],
                ]
            ],
        ];
    }

    public function getDescriptionFieldCreateWalletFailureScenarios()
    {
        return [
            [
                'payload' => [
                    'name' => Str::random(10),
                    'description' => rand(0, 1000)

                ],
                'expected' => [
                    'status_code' => Response::HTTP_UNPROCESSABLE_ENTITY,
                    'validationErrors' => ['description'],
                ]
            ],
        ];
    }

    public function getCreateWalletSuccessScenarios()
    {
        return [
            [
                [
                    'name' => Str::random(10),
                    'description' => md5(rand(0, 10)), 
                ],
                [
                    'name' => Str::random(10),
                    'description' => null, 
                ]
            ]
        ];
    }

}
