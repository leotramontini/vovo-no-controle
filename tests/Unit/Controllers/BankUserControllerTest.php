<?php

namespace Tests\Unit\Controllers;

use Tests\TestCase;
use Vovo\Models\Bank;
use Vovo\Models\User;

class BankUserControllerTest extends TestCase
{
    protected $baseResource;
    protected $token;

    public function setUp() :void
    {
        parent::setUp();

        $this->baseResource = '/api/bank-user';
        $user               = factory(User::class)->create();
        $this->token        = auth()->login($user);
    }

    public function testStore()
    {
        $bank = factory(Bank::class)->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token
        ])->json('POST', $this->baseResource, [
            'bank_id' => $bank->id
        ]);

        $response->assertJsonStructure([
            'data' => [
                'id',
                'user_id',
                'bank_id'
            ]
        ])->assertStatus(200);
    }

    public function testStoreShouldBeFail()
    {
        $bank = factory(Bank::class)->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token
        ])->json('POST', $this->baseResource, [
            $this->faker->word => $bank->id
        ]);

        $response->assertJsonStructure([
            'message',
            'status_code'
        ])->assertStatus(422);
    }
}
