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

    /**
     * @param array $bankData
     * @param int $bankId
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Support\Collection|mixed
     * @throws \Vovo\Exceptions\ServiceProcessException
     */
    public function update($bankData, $bankId)
    {
        try {
            return $this->bankRepository->update($bankData, $bankId);
        } catch (Exception $error) {
            throw new ServiceProcessException($error->getMessage());
        }
    }

    /**
     * @param int $bankId
     * @return int
     * @throws \Vovo\Exceptions\ServiceProcessException
     */
    public function delete($bankId)
    {
        try {
            return $this->bankRepository->delete($bankId);
        } catch (Exception $error) {
            throw new ServiceProcessException($error->getMessage());
        }
    }

    /**
     * @param array $filter
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Support\Collection|mixed
     * @throws ServiceProcessException
     */
    public function index($filter)
    {
        try {
            return $this->bankRepository->findWhere($filter);
        } catch (Exception $error) {
            throw new ServiceProcessException($error->getMessage());
        }
    }
}
