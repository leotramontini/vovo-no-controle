<?php


namespace Tests\Unit\Controllers;


use Carbon\Carbon;
use Tests\TestCase;
use Vovo\Models\Bank;
use Vovo\Models\BankUser;
use Vovo\Models\Bill;
use Vovo\Models\User;

class BillControllerTest extends TestCase
{
    protected $baseResource;
    protected $token;

    public function setUp(): void
    {
        parent::setUp();

        $this->baseResource = '/api/bill';
        $user = factory(User::class)->create();
        $this->token = auth()->login($user);
    }

    public function testStore()
    {
        $user   = factory(User::class)->create();
        $bank   = factory(Bank::class)->create();

        $bankUser = factory(BankUser::class)->create([
            'bank_id'   => $bank->id,
            'user_id'   => $user->id
        ]);

        $inputs = [
            'description'   => $this->faker->word,
            'value'         => (string) $this->faker->randomDigitNotNull,
            'date'          => Carbon::now()->format('Y-m-d'),
            'bank_user_id'  => $bankUser->id
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token
        ])->json('POST', $this->baseResource, $inputs);

        $response->assertJsonStructure([
            'data' => [
                'id',
                'description',
                'value',
                'date',
                'bank_user_id'
            ]
        ])->assertStatus(200);
    }

    public function testStoreShouldBeFail()
    {
        $inputs = [
            'description'   => $this->faker->word,
            'value'         => (string) $this->faker->randomDigitNotNull,
            'date'          => Carbon::now()->format('Y-m-d'),
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token
        ])->json('POST', $this->baseResource, $inputs);

        $response->assertJsonStructure([
            'message',
            'status_code'
        ])->assertStatus(422);
    }

    public function testDelete()
    {
        $user   = factory(User::class)->create();
        $bank   = factory(Bank::class)->create();

        $bankUser = factory(BankUser::class)->create([
            'bank_id'   => $bank->id,
            'user_id'   => $user->id
        ]);

        $bill = factory(Bill::class)->create([
            'bank_user_id' => $bankUser->id
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token
        ])->json('DELETE', $this->baseResource . '/' . $bill->id);

        $response->assertJson([
            'data' => [
                'message' => 'Bill has deleted with success'
            ]
        ])->assertStatus(200);
    }

    public function testDeleteShouldBeFail()
    {
        $user   = factory(User::class)->create();
        $bank   = factory(Bank::class)->create();

        $bankUser = factory(BankUser::class)->create([
            'bank_id'   => $bank->id,
            'user_id'   => $user->id
        ]);

        $bill = factory(Bill::class)->create([
            'bank_user_id' => $bankUser->id
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token
        ])->json('DELETE', $this->baseResource . '/' . ($bill->id + $this->faker->randomDigitNotNull));

        $response->assertJsonStructure([
            'message',
            'status_code'
        ])->assertStatus(422);
    }
}
