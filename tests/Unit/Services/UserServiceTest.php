<?php


namespace Tests\Unit\Services;

use Mockery;
use Exception;
use Tests\TestCase;
use Vovo\Models\User;
use Vovo\Services\UserService;
use Vovo\Repositories\UserRepository;
use Vovo\Exceptions\ServiceProcessException;

class UserServiceTest extends TestCase
{
    protected $userRepository;
    protected $userService;

    public function setUp(): void
    {
        parent::setUp();

        $this->userRepository   = Mockery::mock(UserRepository::class);
        $this->userService      = new UserService($this->userRepository);
    }

    public function testStore()
    {
        $user = [
            'name'      => $this->faker->name,
            'email'     => $this->faker->email,
            'password'  => $this->faker->word
        ];

        $this->userRepository
            ->shouldReceive('create')
            ->once()
            ->andReturn(Mockery::mock(User::class));

        $this->assertInstanceOf(User::class, $this->userService->store($user));
    }

    public function testStoreShouldBeFail()
    {
        $user = [
            'name'      => $this->faker->name,
            'email'     => $this->faker->email,
            'password'  => $this->faker->word
        ];

        $this->userRepository
            ->shouldReceive('create')
            ->once()
            ->andThrow(Exception::class);

        $this->expectException(ServiceProcessException::class);
        $this->userService->store($user);
    }
}
