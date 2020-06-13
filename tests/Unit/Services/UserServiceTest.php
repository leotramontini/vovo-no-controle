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


    public function testUpdatee()
    {
        $user = factory(User::class)->create();

        $inputs = [
            'name'      => $this->faker->name
        ];

        $this->userRepository
            ->shouldReceive('update')
            ->with($inputs, $user->id)
            ->once()
            ->andReturn(Mockery::mock(User::class));

        $this->assertInstanceOf(User::class, $this->userService->update($inputs, $user->id));
    }

    public function testUpdateShouldBeFail()
    {
        $user = factory(User::class)->create();

        $inputs = [
            'name'      => $this->faker->name
        ];

        $userId = $user->id + $this->faker->randomDigitNotNull;

        $this->userRepository
            ->shouldReceive('update')
            ->with($inputs, $userId)
            ->once()
            ->andThrow(Exception::class);

        $this->expectException(ServiceProcessException::class);
        $this->userService->update($inputs, $userId);
    }

    public function testDelete()
    {
        $user = factory(User::class)->create();

        $this->userRepository
            ->shouldReceive('delete')
            ->with($user->id)
            ->once()
            ->andReturn(1);

        $this->assertEquals(1, $this->userService->delete($user->id));
    }

    public function testDeleteShouldBeFail()
    {
        $user = factory(User::class)->create();

        $this->userRepository
            ->shouldReceive('delete')
            ->with($user->id)
            ->once()
            ->andThrow(Exception::class);

        $this->expectException(ServiceProcessException::class);
        $this->userService->delete($user->id);
    }

    public function testIndex()
    {
        $user = factory(User::class)->create();

        $filter = [
            'id'    => $user->id
        ];

        $this->userRepository
            ->shouldReceive('findWhere')
            ->with($filter)
            ->once()
            ->andReturn(collect([$user]));

        $this->assertEquals(collect([$user]), $this->userService->index($filter));
    }

    public function testIndexShouldBeFail()
    {
        $user = factory(User::class)->create();

        $filter = [
            'id' => $user->id
        ];

        $this->userRepository
            ->shouldReceive('findWhere')
            ->with($filter)
            ->once()
            ->andThrow(Exception::class);

        $this->expectException(ServiceProcessException::class);
        $this->userService->index($filter);
    }

    public function testIndexWithEmptyResult()
    {
        $user = factory(User::class)->create();

        $filter = [
            'id' => $user->id + $this->faker->randomDigitNotNull
        ];

        $this->userRepository
            ->shouldReceive('findWhere')
            ->with($filter)
            ->once()
            ->andThrow(collect([]));

        $this->expectException(ServiceProcessException::class);
        $this->userService->index($filter);
    }


}
