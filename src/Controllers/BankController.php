<?php

namespace Vovo\Controllers;

use Validator;
use Illuminate\Http\Request;
use Vovo\Support\BankSupport;
use Vovo\Services\BankService;
use Vovo\Transformer\BankTransformer;
use Vovo\Exceptions\ServiceProcessException;

class BankController extends BaseController
{
    /**
     * @var \Vovo\Services\BankService
     */
    protected $bankService;

    /**
     * BankController construct
     * @param \Vovo\Services\BankService $bankServices
     */
    public function __construct(BankService $bankServices)
    {
        $this->bankService = $bankServices;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $inputs = $request->all();
        $validator = Validator::make($inputs, BankSupport::CREATE_FIELD_VALIDATOR);

        if ($validator->fails()) {
            $this->throwErrorBadRequest();
        }

        try {
            $bank = $this->bankService->create($inputs);
            return $this->item($bank, new BankTransformer());
        } catch (ServiceProcessException $error) {
            $this->throwErrorStore($error->getMessage());
        }
    }
}
