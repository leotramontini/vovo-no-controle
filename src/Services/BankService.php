<?php

namespace Vovo\Services;

use Exception;
use Vovo\Repositories\BankRepository;
use Vovo\Exceptions\ServiceProcessException;

class BankService
{
    protected $bankRepository;

    /**
     * BankService construct
     * @param BankRepository $bankRepository
     */
    public function __construct(BankRepository $bankRepository)
    {
        $this->bankRepository = $bankRepository;
    }

    /**
     * @param array $bankData
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Support\Collection|mixed
     * @throws \Vovo\Exceptions\ServiceProcessException
     */
    public function create($bankData)
    {
        try {
            return $this->bankRepository->create($bankData);
        } catch (Exception $error) {
            throw new ServiceProcessException($error->getMessage());
        }
    }
}
