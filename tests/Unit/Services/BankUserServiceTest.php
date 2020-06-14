<?php


namespace Tests\Unit\Services;

use Mockery;
use \Exception;
use Tests\TestCase;
use Vovo\Exceptions\ServiceProcessException;
use Vovo\Models\Bank;
use Vovo\Models\User;
use Vovo\Models\BankUser;
use Vovo\Services\BankUserService;
use Vovo\Repositories\BankUserRepository;

class BankUserServiceTest extends TestCase
{
    protected $bankUserService;
    protected $bankUserRepository;

    public function setUp(): void
    {
        parent::setUp();
        $this->bankUserRepository = Mockery::mock(BankUserRepository::class);
        $this->bankUserService = new BankUserService($this->bankUserRepository);
    }

    public function testStore()
    {
        $bank   = factory(Bank::class)->create();
        $user   = factory(User::class)->create();

        $this->bankUserRepository
            ->shouldReceive('firstOrCreate')
            ->with([
                'bank_id' => $bank->id,
                'user_id' => $user->id,
            ])
            ->once()
            ->andReturn(Mockery::mock(BankUser::class));

        $this->assertInstanceOf(BankUser::class, $this->bankUserService->store($bank->id, $user->id));
    }

    public function testStoreShouldBeFail()
    {
        $bank   = factory(Bank::class)->create();
        $user   = factory(User::class)->create();

        $this->bankUserRepository
            ->shouldReceive('firstOrCreate')
            ->with([
                'bank_id' => $bank->id,
                'user_id' => $user->id,
            ])
            ->once()
            ->andThrow(Exception::class);

        $this->expectException(ServiceProcessException::class);
        $this->bankUserService->store($bank->id, $user->id);
    }
}
