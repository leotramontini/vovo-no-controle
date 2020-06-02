<?php

namespace Tests\Unit\Controllers;

use Tests\TestCase;
use Vovo\Models\User;

class UserControllerTest extends TestCase
{
    protected $baseResource;

    public function setUp():void
    {
        parent::setUp();
        $this->baseResource = '/api/user';
    }

    public function testStore()
    {
        $response = $this->json('POST', $this->baseResource, [
            'name'      => $this->faker->name,
            'email'     => $this->faker->email,
            'password'  => $this->faker->word
        ]);

        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'email'
            ]
        ])->assertStatus(200);
    }

    public function testStoreShouldBeFail()
    {
        $response = $this->json('POST', $this->baseResource, [
            'email'     => $this->faker->email,
            'password'  => $this->faker->word
        ]);

        $response->assertJsonStructure([
            'message',
            'status_code'
        ])->assertStatus(400);
    }
}
