<?php

namespace Vovo\Controllers;

use Validator;
use Exception;
use Illuminate\Support\Arr;
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
     * @throws Exception
     */
    public function store(Request $request)
    {
        $inputs = $request->all();

        try {
            $validator = Validator::make($inputs, BankSupport::CREATE_FIELD_VALIDATOR);
            if ($validator->fails()) {
                $messages   = $validator->getMessageBag()->messages();
                $message    = Arr::first(Arr::first($messages));
                throw new Exception($message);
            }

            $bank = $this->bankService->create($inputs);

        } catch (Exception $error) {
            $this->throwErrorStore($error->getMessage());
        }

        return $this->item($bank, new BankTransformer());
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param int $bankId
     * @return mixed
     * @throws Exception
     */
    public function update(Request $request, $bankId)
    {
        $inputs = $request->all();

        try {
            $validator = Validator::make($inputs, BankSupport::CREATE_FIELD_VALIDATOR);

            if ($validator->fails()) {
                $messages   = $validator->getMessageBag()->messages();
                $message    = Arr::first(Arr::first($messages));
                throw new Exception($message);
            }

            $bank = $this->bankService->update($request->all(), $bankId);
        } catch (Exception $error) {
            $this->throwErrorUpdate($error->getMessage());
        }

        return $this->item($bank, new BankTransformer());
    }

    /**
     * @param int $bankId
     * @return mixed
     */
    public function delete($bankId)
    {
        try {
            $this->bankService->delete($bankId);
        } catch (ServiceProcessException $error) {
            $this->throwErrorDelete($error->getMessage());
        }

        return $this->array([
            'data' => [
                'message' => 'Bank was delete with success'
            ]
        ]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        try {
            $banks = $this->bankService->index($request->all());
        } catch (ServiceProcessException $error) {
            $this->throwErrorNotFound($error->getMessage());
        }

        return $this->collection($banks, new BankTransformer());
    }
}
