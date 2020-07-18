<?php


namespace Vovo\Services;

use Exception;
use Illuminate\Support\Arr;
use Vovo\Repositories\BillRepository;
use Vovo\Repositories\BankUserRepository;
use Vovo\Exceptions\ServiceProcessException;

class BillService
{
    /**
     * @var \Vovo\Repositories\BillRepository
     */
    protected $billRepository;

    /**
     * @var \Vovo\Repositories\BankUserRepository
     */
    protected $bankUserRepository;

    /**
     * BillService constructor.
     * @param \Vovo\Repositories\BillRepository $billRepository
     * @param \Vovo\Repositories\BankUserRepository $bankUserRepository
     */
    public function __construct(BillRepository $billRepository, BankUserRepository $bankUserRepository)
    {
        $this->billRepository       = $billRepository;
        $this->bankUserRepository   = $bankUserRepository;
    }

    /**
     * @param array $inputs
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Support\Collection|mixed
     * @throws \Vovo\Exceptions\ServiceProcessException
     */
    public function store($inputs)
    {
        try {
            $bill = $this->billRepository->create($inputs);
            $this->updateBankUserBalance(Arr::get($inputs, 'bank_user_id'), Arr::get($inputs, 'value'));
            return $bill;
        } catch (Exception $error) {
            throw new ServiceProcessException($error->getMessage());
        }
    }

    /**
     * @param int $bankUserId
     * @param float $value
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Support\Collection|mixed
     * @throws \Vovo\Exceptions\ServiceProcessException
     */
    public function updateBankUserBalance($bankUserId, $value)
    {
        try {
            $bankUser = $this->getBankUserById($bankUserId);
            $balance = $bankUser->balance + $value;
            return $this->bankUserRepository->update(['balance' => $balance], $bankUser->id);
        } catch (Exception $error) {
            throw new ServiceProcessException($error->getMessage());
        }
    }

    /**
     * @param int $bankUserId
     * @return \Vovo\Models\BankUser
     */
    public function getBankUserById($bankUserId)
    {
        try {
            return $this->bankUserRepository->findByField('id', $bankUserId)->first();
        } catch (Exception $error) {
            throw new ServiceProcessException($error->getMessage());
        }
    }

    /**
     * @param int $billId
     * @return int
     * @throws \Vovo\Exceptions\ServiceProcessException
     */
    public function delete($billId)
    {
        try {
            return $this->billRepository->delete($billId);
        } catch (Exception $error) {
            throw new ServiceProcessException($error->getMessage());
        }
    }
}
