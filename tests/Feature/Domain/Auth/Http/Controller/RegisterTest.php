<?php

namespace Tests\Feature\Domain\Auth\Http\Controller;

use App\Domain\Auth\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use DatabaseMigrations;

    
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        $this->faker =  \Faker\Factory::create('pt_BR');
        parent::__construct($name,$data, $dataName);
    }

    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @dataProvider getNameFieldRegistryFailureScenarios
     * @dataProvider getEmailFieldRegistryFailureScenarios
     * @dataProvider getPasswordFieldRegistryFailureScenarios
     */
    public function testMustFailRegistryAttemptWithoutCorrectData(array $payload, $expected)
    {
        $response = $this->postJson(
            route('auth.register'),
            $payload
        );

        $response->assertStatus($expected['status_code']);
        $response->assertJsonValidationErrors($expected['validationErrors']);
    }

    public function testRegistrationEmailAlreadyInUse()
    {
        $user = User::factory()->create();

        $payload = [
            'name' => 'Name',
            'email' => $user->email,
            'password' => 'password'
        ];

        $response = $this->postJson(
            route('auth.register'),
            $payload
        );

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(['email']);
    }

    public function testRegisterUser()
    {
        $password = 'password';
        $payload = [
            'name' => 'Name',
            'email' => 'test@test.com',
            'password' => $password,
            "password_confirmation" => $password
        ];

        $response = $this->postJson(
            route('auth.register'),
            $payload
        );

        $response->assertStatus(Response::HTTP_CREATED);
        $this->assertDatabaseCount('users', 1);
        $this->assertDatabaseHas('users', [
            'email' => $payload['email'],
        ]);

        $this->assertDatabaseCount('wallets', 1);
        $this->assertDatabaseHas('wallets', [
            'name' => 'Default',
        ]);
    }

    public function getNameFieldRegistryFailureScenarios()
    {
        return [
            'Name is required' => [
                'payload' => [
                    'email'   => $this->faker->email,
                    'password' => md5(rand(0, 10)),

                ],
                'expected' => [
                    'status_code' => Response::HTTP_UNPROCESSABLE_ENTITY,
                    'validationErrors' => ['name'],
                ]
            ],
            'Name must be a string' =>  [
                'payload' => [
                    'name'   => rand(0, 100),
                    'email'   => $this->faker->email,
                    'password' => md5(rand(0, 10)),
                ],
                'expected'  => [
                    'status_code' => Response::HTTP_UNPROCESSABLE_ENTITY,
                    'validationErrors' => ['name'],
                ]
            ],
            'Name must not be greater than 255 characters' => [
                'payload' => [
                    'name'   => Str::random(256),
                    'email'   => $this->faker->email,
                    'password' => md5(rand(0, 10)),
                ],
                'expected'  => [
                    'status_code' => Response::HTTP_UNPROCESSABLE_ENTITY,
                    'validationErrors' => ['name'],
                ]
            ]
        ];
    }

    public function getEmailFieldRegistryFailureScenarios()
    {
        return [
            'Email is required' => [
                'payload' => [
                    'password' => md5(rand(0, 10)),
                ],
                'expected' => [
                    'status_code' => Response::HTTP_UNPROCESSABLE_ENTITY,
                    'validationErrors' => ['email'],
                ]
            ],
            'Email must be valid' => [
                'payload' => [
                    'email'   => 'test.testecxw.com',
                    'password' => md5(rand(0, 10)),
                ],
                'expected'  => [
                    'status_code' => Response::HTTP_UNPROCESSABLE_ENTITY,
                    'validationErrors' => ['email'],
                ]
            ],
            'Email must be a string' => [
                'payload' => [
                    'email'   => rand(0, 100),
                    'password' => md5(rand(0, 10)),
                ],
                'expected'  => [
                    'status_code' => Response::HTTP_UNPROCESSABLE_ENTITY,
                    'validationErrors' => ['email'],
                ]
            ],
            'Email must not be greater than 255 characters.' =>  [
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

    public function getPasswordFieldRegistryFailureScenarios()
    {
        return [
            'Password is required' => [
                'payload' => [
                    'email'   => $this->faker->email,
                ],
                'expected' => [
                    'status_code' => Response::HTTP_UNPROCESSABLE_ENTITY,
                    'validationErrors' => ['password'],
                ]
            ],
            'password must be a string' => [
                'payload' => [
                    'email'   => $this->faker->email,
                    'password' => rand(0, 100),
                ],
                'expected'  => [
                    'status_code' => Response::HTTP_UNPROCESSABLE_ENTITY,
                    'validationErrors' => ['password'],
                ]
            ],
            'Password must be at least 8 characters' =>  [
                'payload' => [
                    'email'   => $this->faker->email,
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
