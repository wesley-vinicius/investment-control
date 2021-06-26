<?php

namespace Tests\Feature\Domain\Auth\Http\Controller;

use App\Domain\Auth\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @dataProvider getEmailFieldLoginFailureScenarios
     * @dataProvider getPasswordFieldLoginFailureScenarios
     */
    public function testMustFailLoginAttemptWithoutCorrectData(array $payload, $expected)
    {
        $response = $this->postJson(
            route('auth.login'),
            $payload
        );

        $response->assertStatus($expected['status_code']);
        $response->assertJsonValidationErrors($expected['validationErrors']);
    }

    public function testNotLoginIncorrectData()
    {
        $user = User::factory()->create();

        $payload = [
            'email' => $user->email,
            'password' => '1222332434'
        ];

        $response = $this->postJson(
            route('auth.login'),
            $payload
        );

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
        $response->assertJson(['message' => true]);
        $this->assertFalse(Auth::check());
    }

    public function testLogin()
    {
        $user = User::factory()->create();
        $payload = [
            'email' => $user->email,
            'password' => 'password'
        ];

        $response = $this->postJson(
            route('auth.login'),
            $payload
        );

        $response->assertOk();
        $response->assertJson([
            'token' => true,
        ]);
        $this->assertTrue(Auth::check());
        $this->assertEquals($user->id, Auth::id());
    }

    public function getEmailFieldLoginFailureScenarios()
    {
        return [
            [
                'payload' => [
                    'password' => md5(rand(0, 10)),
                ],
                'expected' => [
                    'status_code' => Response::HTTP_UNPROCESSABLE_ENTITY,
                    'validationErrors' => ['email'],
                ]
            ],
            [
                'payload' => [
                    'email'   => 'test.testecxw.com',
                    'password' => md5(rand(0, 10)),
                ],
                'expected'  => [
                    'status_code' => Response::HTTP_UNPROCESSABLE_ENTITY,
                    'validationErrors' => ['email'],
                ]
            ],
            [
                'payload' => [
                    'email'   => rand(0, 100),
                    'password' => md5(rand(0, 10)),
                ],
                'expected'  => [
                    'status_code' => Response::HTTP_UNPROCESSABLE_ENTITY,
                    'validationErrors' => ['email'],
                ]
            ],
            [
                'payload' => [
                    'email'   => Str::random(256) . '@test.com',
                    'password' => md5(rand(0, 10)),
                ],
                'expected'  => [
                    'status_code' => Response::HTTP_UNPROCESSABLE_ENTITY,
                    'validationErrors' => ['email'],
                ]
            ]
        ];
    }

    public function getPasswordFieldLoginFailureScenarios()
    {
        $faker = \Faker\Factory::create('pt_BR');
        return [
            [
                'payload' => [
                    'email'   => $faker->email,
                ],
                'expected' => [
                    'status_code' => Response::HTTP_UNPROCESSABLE_ENTITY,
                    'validationErrors' => ['password'],
                ]
            ],
            [
                'payload' => [
                    'email'   => $faker->email,
                    'password' => rand(0, 100),
                ],
                'expected'  => [
                    'status_code' => Response::HTTP_UNPROCESSABLE_ENTITY,
                    'validationErrors' => ['password'],
                ]
            ],
            [
                'payload' => [
                    'email'   => $faker->email,
                    'password' => 'passwww',
                ],
                'expected'  => [
                    'status_code' => Response::HTTP_UNPROCESSABLE_ENTITY,
                    'validationErrors' => ['password'],
                ]
            ],
        ];
    }

}
