<?php

namespace Tests\Unit\Services;

use Mockery;
use Exception;
use Tests\TestCase;
use Vovo\Models\Bank;
use Vovo\Services\BankService;
use Vovo\Repositories\BankRepository;
use Vovo\Exceptions\ServiceProcessException;

class BankServiceTest extends TestCase
{
    protected $service;
    protected $bankRepository;

    public function setUp(): void
    {
        parent::setUp();

        $this->bankRepository   = Mockery::mock(BankRepository::class);
        $this->service          = new BankService($this->bankRepository);
    }

    public function testCreate()
    {
        $bankName = $this->faker->name;

        $bank = factory(Bank::class)->make([
            'name' => $bankName
        ]);

        $this->bankRepository
            ->shouldReceive('create')
            ->once()
            ->andReturn($bank);

        $this->assertEquals($bank, $this->service->create(['name' => $bankName]));

    }

    public function testCreateShouldBeFail()
    {
        $bankName = $this->faker->name;

        $this->bankRepository
            ->shouldReceive('create')
            ->once()
            ->andThrow(Exception::class);

        $this->expectException(ServiceProcessException::class);
        $this->service->create(['name' => $bankName]);
    }
}
