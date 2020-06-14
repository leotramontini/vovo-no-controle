<?php

namespace Vovo\Controllers;

use Exception;
use Validator;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Vovo\Support\BankUserSupport;
use Vovo\Services\BankUserService;
use Vovo\Transformer\BankUserTransformer;
use Vovo\Exceptions\ServiceProcessException;

class BankUserController extends BaseController
{
    /**
     * @var \Vovo\Services\BankUserService
     */
    protected $bankUserService;

    /**
     * BankUserController constructor.
     * @param \Vovo\Services\BankUserService $bankUserService
     */
    public function __construct(BankUserService $bankUserService)
    {
        $this->bankUserService = $bankUserService;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return mixed
     * @throws Exception
     */
    public function store(Request $request)
    {
        try {
            $user = $this->loggedUser();

            $inputs = $request->all();
            $validator = Validator::make($inputs, BankUserSupport::CREATE_FIELD);

            if ($validator->fails()) {
                $messages   = $validator->getMessageBag()->messages();
                $message    = Arr::first(Arr::first($messages));
                throw new Exception($message);
            }

            $bankUser = $this->bankUserService->store(Arr::get($inputs, 'bank_id'), $user->id);
            return $this->item($bankUser, new BankUserTransformer());
        } catch (ServiceProcessException $error) {
            $this->throwErrorStore($error->getMessage());
        }
    }
}
