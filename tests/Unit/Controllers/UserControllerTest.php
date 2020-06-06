<?php

namespace Tests\Unit\Controllers;

use Tests\TestCase;
use Vovo\Models\User;

class UserControllerTest extends TestCase
{
    protected $baseResource;
    protected $token;

    public function setUp():void
    {
        parent::setUp();
        $this->baseResource = '/api/user';
        $user = factory(User::class)->create();
        $this->token = auth()->login($user);
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

    public function testUpdate()
    {
        $user = factory(User::class)->create();

        $newName = $this->faker->name;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token
        ])->json('PUT', $this->baseResource . '/' . $user->id, [
            'name'  => $newName
        ]);

        $response->assertJson([
            'data' => [
                'id'    => $user->id,
                'name'  => $newName,
                'email' => $user->email
            ]
        ])->assertStatus(200);
    }

    public function testUpdateShouldBeFail()
    {
        $user = factory(User::class)->create();

        $userId = $this->faker->randomDigitNotNull + $user->id;

        $newName = $this->faker->name;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token
        ])->json('PUT', $this->baseResource . '/' . $userId, [
            'name'  => $newName
        ]);

        $response->assertJsonStructure([
            'message',
            'status_code'
        ])->assertStatus(422);
    }
}
