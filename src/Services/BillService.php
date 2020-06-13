<?php


namespace Vovo\Services;

use Exception;
use Illuminate\Support\Arr;
use Vovo\Exceptions\ServiceProcessException;
use Vovo\Repositories\BillRepository;

class BillService
{
    /**
     * @var \Vovo\Repositories\BillRepository
     */
    protected $billRepository;

    /**
     * BillService constructor.
     * @param \Vovo\Repositories\BillRepository $billRepository
     */
    public function __construct(BillRepository $billRepository)
    {
        $this->billRepository = $billRepository;
    }

    public function store($inputs)
    {
        try {
//            $this->updateBankUserBalance(Arr::get($inputs, 'bank_user_id'), Arr::get($inputs, 'value'));
            return $this->billRepository->create($inputs);
        } catch (Exception $error) {
            throw new ServiceProcessException($error->getMessage());
        }
    }
}
