<?php

namespace Tests\Unit\Controllers;

use Tests\TestCase;
use Vovo\Models\Bank;
use Vovo\Models\User;

class BankControllerTest extends TestCase
{
    protected $baseResource;
    protected $token;

    public function setUp(): void
    {
        parent::setUp();
        $this->baseResource = '/api/bank';
        $user = factory(User::class)->create();
        $this->token = auth()->login($user);
    }

    public function testStore()
    {
        $bankName = $this->faker->name;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' .  $this->token
        ])->json('POST', $this->baseResource, [
            'name' => $bankName
        ]);

        $expected = [
            'data' => [
                'id',
                'name'
            ]
        ];

        $response->assertJsonStructure($expected)
            ->assertStatus(200);
    }

    public function testStoreShouldValidatorError()
    {
        $bankName = $this->faker->name;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' .  $this->token
        ])->json('POST', $this->baseResource, [
            'name1' => $bankName
        ]);

        $expected = [
            'message',
            'status_code'
        ];

        $response->assertJsonStructure($expected)
            ->assertStatus(422);
    }

    public function testUpdate()
    {
        $bank = factory(Bank::class)->create();
        $bankName = $this->faker->name;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' .  $this->token
        ])->json('PUT', $this->baseResource . '/' . $bank->id, [
            'name' => $bankName
        ]);

        $expected = [
            'data' => [
                'id'    => $bank->id,
                'name'  => $bankName
            ]
        ];

        $response->assertJson($expected)
            ->assertStatus(200);
    }

    public function testUpdateShouldValidatorError()
    {
        $bank = factory(Bank::class)->create();
        $bankName = $this->faker->name;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' .  $this->token
        ])->json('PUT', $this->baseResource . '/' . $bank->id, [
            'name1' => $bankName
        ]);

        $expected = [
            'message',
            'status_code'
        ];

        $response->assertJsonStructure($expected)
            ->assertStatus(422);
    }

    public function testDelete()
    {
        $bank = factory(Bank::class)->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' .  $this->token
        ])->json('DELETE', $this->baseResource . '/' . $bank->id);

        $expected = [
            'data' => [
                'message' => 'Bank was delete with success'
            ]
        ];

        $response->assertJson($expected)
            ->assertStatus(200);
    }

    public function testDeleteShouldValidatorError()
    {
        $bank = factory(Bank::class)->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' .  $this->token
        ])->json('DELETE', $this->baseResource . '/' . ($bank->id + $this->faker->randomDigitNotNull));

        $expected = [
            'message',
            'status_code'
        ];

        $response->assertJsonStructure($expected)
            ->assertStatus(422);
    }

    public function testIndex()
    {
        $bank = factory(Bank::class)->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' .  $this->token
        ])->json('GET', $this->baseResource . '?name=' . $bank->name);

        $expected = [
            'data' => [
                [
                    'id'    => $bank->id,
                    'name'  => $bank->name
                ]
            ]
        ];

        $response->assertJson($expected)
            ->assertStatus(200);
    }

    public function testIndexShouldValidatorError()
    {
        factory(Bank::class)->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' .  $this->token
        ])->json('GET', $this->baseResource . '?' . $this->faker->name . '=' . $this->faker->name);

        $expected = [
            'message',
            'status_code'
        ];

        $response->assertJsonStructure($expected)
            ->assertStatus(404);
    }
}
