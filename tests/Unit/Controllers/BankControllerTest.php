<?php

namespace Tests\Unit\Controllers;

use Mockery;
use Exception;
use Tests\TestCase;
use Vovo\Models\Bank;
use Vovo\Repositories\BankRepository;

class BankControllerTest extends TestCase
{
    protected $baseResource;

    public function setUp(): void
    {
        parent::setUp();
        $this->baseResource = '/api/bank';
    }

    public function testStore()
    {
        $bankName = $this->faker->name;

        $response = $this->json('POST', $this->baseResource, [
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

        $response = $this->json('POST', $this->baseResource, [
            'name1' => $bankName
        ]);

        $expected = [
            'message',
            'status_code'
        ];

        $response->assertJsonStructure($expected)
            ->assertStatus(400);
    }

    public function testUpdate()
    {
        $bank = factory(Bank::class)->create();
        $bankName = $this->faker->name;

        $response = $this->json('PUT', $this->baseResource . '/' . $bank->id, [
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

        $response = $this->json('PUT', $this->baseResource . '/' . $bank->id, [
            'name1' => $bankName
        ]);

        $expected = [
            'message',
            'status_code'
        ];

        $response->assertJsonStructure($expected)
            ->assertStatus(400);
    }
}
