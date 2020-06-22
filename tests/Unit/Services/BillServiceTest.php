<?php


namespace Tests\Unit\Services;

use Mockery;
use Exception;
use Tests\TestCase;
use Vovo\Exceptions\ServiceProcessException;
use Vovo\Models\Bill;
use Vovo\Models\User;
use Vovo\Models\Bank;
use Vovo\Models\BankUser;
use Vovo\Services\BillService;
use Vovo\Repositories\BillRepository;
use Vovo\Repositories\BankUserRepository;

class BillServiceTest extends TestCase
{
    protected $billRepository;
    protected $bankUserRepository;
    protected $billService;

    public function setUp(): void
    {
        parent::setUp();

        $this->billRepository       = Mockery::mock(BillRepository::class);
        $this->bankUserRepository   = Mockery::mock(BankUserRepository::class);
        $this->billService          = new BillService($this->billRepository, $this->bankUserRepository);
    }

    public function testGetBankUserById()
    {
        $user = factory(User::class)->create();

        $bank = factory(Bank::class)->create();

        $bankUser = factory(BankUser::class)->create([
            'user_id'   => $user->id,
            'bank_id'   => $bank->id
        ]);

        $this->bankUserRepository
            ->shouldReceive('findByField')
            ->with('id', $bankUser->id)
            ->once()
            ->andReturn(collect([$bankUser]));

        $this->assertInstanceOf(BankUser::class, $this->billService->getBankUserById($bankUser->id));
    }

    public function testGetBankUserByIdShouldBeFail()
    {
        $user = factory(User::class)->create();

        $bank = factory(Bank::class)->create();

        $bankUser = factory(BankUser::class)->create([
            'user_id'   => $user->id,
            'bank_id'   => $bank->id
        ]);

        $this->bankUserRepository
            ->shouldReceive('findByField')
            ->with('id', $bankUser->id)
            ->once()
            ->andThrow(Exception::class);

        $this->expectException(ServiceProcessException::class);
        $this->billService->getBankUserById($bankUser->id);
    }

    public function testUpdateBankUserBalance()
    {
        $user = factory(User::class)->create();

        $bank = factory(Bank::class)->create();

        $bankUser = factory(BankUser::class)->create([
            'user_id'   => $user->id,
            'bank_id'   => $bank->id
        ]);

        $this->bankUserRepository
            ->shouldReceive('findByField')
            ->with('id', $bankUser->id)
            ->once()
            ->andReturn(collect([$bankUser]));

        $value = $this->faker->randomDigitNotNull;
        $balance = $bankUser->balance + $value;
        $this->bankUserRepository
            ->shouldReceive('update')
            ->with(['balance' => $balance], $bankUser->id)
            ->once()
            ->andReturn(1);

        $this->assertEquals(1, $this->billService->updateBankUserBalance($bankUser->id, $value));
    }

    public function testUpdateBankUserBalanceShouldBeFail()
    {
        $user = factory(User::class)->create();

        $bank = factory(Bank::class)->create();

        $bankUser = factory(BankUser::class)->create([
            'user_id'   => $user->id,
            'bank_id'   => $bank->id
        ]);

        $this->bankUserRepository
            ->shouldReceive('findByField')
            ->with('id', $bankUser->id)
            ->once()
            ->andReturn(collect([$bankUser]));

        $value = $this->faker->randomDigitNotNull;
        $balance = $bankUser->balance + $value;
        $this->bankUserRepository
            ->shouldReceive('update')
            ->with(['balance' => $balance], $bankUser->id)
            ->once()
            ->andThrow(Exception::class);

        $this->expectException(ServiceProcessException::class);
        $this->billService->updateBankUserBalance($bankUser->id, $value);
    }

    public function testStore()
    {
        $user = factory(User::class)->create();

        $bank = factory(Bank::class)->create();

        $bankUser = factory(BankUser::class)->create([
            'user_id'   => $user->id,
            'bank_id'   => $bank->id
        ]);

        $this->bankUserRepository
            ->shouldReceive('findByField')
            ->with('id', $bankUser->id)
            ->once()
            ->andReturn(collect([$bankUser]));

        $value = $this->faker->randomDigitNotNull;
        $balance = $bankUser->balance + $value;
        $this->bankUserRepository
            ->shouldReceive('update')
            ->with(['balance' => $balance], $bankUser->id)
            ->once()
            ->andReturn(1);

        $inputs = [
            'value'         => $value,
            'bank_user_id'  => $bankUser->id
        ];

        $this->billRepository
            ->shouldReceive('create')
            ->with($inputs)
            ->once()
            ->andReturn(Mockery::mock(Bill::class));

        $this->assertInstanceOf(Bill::class, $this->billService->store($inputs));
    }

    public function testStoreShouldBeFail()
    {
        $user = factory(User::class)->create();

        $bank = factory(Bank::class)->create();

        $bankUser = factory(BankUser::class)->create([
            'user_id'   => $user->id,
            'bank_id'   => $bank->id
        ]);

        $value = $this->faker->randomDigitNotNull;
        $inputs = [
            'value'         => $value,
            'bank_user_id'  => $bankUser->id
        ];

        $this->billRepository
            ->shouldReceive('create')
            ->with($inputs)
            ->once()
            ->andThrow(Exception::class);

        $this->expectException(ServiceProcessException::class);
        $this->billService->store($inputs);
    }
}
