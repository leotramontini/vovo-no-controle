<?php

namespace Tests\Unit\Controllers;

use Mockery;
use Exception;
use Tests\TestCase;
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
}
