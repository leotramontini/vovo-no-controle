<?php

namespace Tests\Unit\Controllers;

use Tests\TestCase;
use Vovo\Models\User;

class AuthControllerTest extends TestCase
{
    public function testLogin()
    {
        $password = $this->faker->password;

        $user = factory(User::class)->create([
            'password' => bcrypt($password)
        ]);

        $response = $this->json('POST', 'api/login', ['email' => $user->email, 'password' => $password]);

        $response->assertJsonStructure([
            "access_token",
            "token_type",
            "expires_in"
        ])->assertStatus(200);
    }

    public function testLoginShouldBeFail()
    {
        $password = $this->faker->password;
        $user = factory(User::class)->create();

        $response = $this->json('POST', 'api/login', ['email' => $user->email, 'password' => $password]);

        $response->assertJsonStructure([
            "error"
        ])->assertStatus(401);
    }

    public function testRefresh()
    {
        $password = $this->faker->password;

        $user = factory(User::class)->create([
            'password' => bcrypt($password)
        ]);

        $this->json('POST', 'api/login', ['email' => $user->email, 'password' => $password]);
        $response = $this->json('POST', 'api/refresh');

        $response->assertJsonStructure([
            "access_token",
            "token_type",
            "expires_in"
        ])->assertStatus(200);
    }

    public function testLogout()
    {
        $password = $this->faker->password;

        $user = factory(User::class)->create([
            'password' => bcrypt($password)
        ]);

        $this->json('POST', 'api/login', ['email' => $user->email, 'password' => $password]);
        $response = $this->json('POST', 'api/logout');

        $response->assertJsonStructure([
            "message"
        ])->assertStatus(200);
    }

    public function testMe()
    {
        $password = $this->faker->password;

        $user = factory(User::class)->create([
            'password' => bcrypt($password)
        ]);

        $this->json('POST', 'api/login', ['email' => $user->email, 'password' => $password]);
        $response = $this->json('POST', 'api/me');

        $response->assertJsonStructure([
            "id",
            "name",
            "email_verified_at",
            "created_at",
            "updated_at"
        ])->assertStatus(200);
    }
}
