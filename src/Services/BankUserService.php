<?php


namespace Vovo\Services;

use SebastianBergmann\ObjectReflector\InvalidArgumentException;
use Vovo\Repositories\BankUserRepository;

class BankUserService
{
    /**
     * @var BankUserRepository
     */
    protected $bankUserRepository;

    public function __construct(BankUserRepository $bankUserRepository)
    {
        $this->bankUserRepository = $bankUserRepository;
    }

    /**
     * @param int $bankId
     * @param int $userId
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Support\Collection|mixed
     */
    public function store($bankId, $userId)
    {
        try {
            return $this->bankUserRepository->firstOrCreate(['bank_id' => $bankId, 'user_id' => $userId]);
        } catch (Exception $error) {
            throw new InvalidArgumentException($error->getMessage());
        }
    }
}
