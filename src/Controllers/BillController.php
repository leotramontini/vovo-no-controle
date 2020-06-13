<?php

namespace Vovo\Controllers;

use Validator;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Vovo\Support\BillSupport;
use Vovo\Services\BillService;
use Vovo\Exceptions\ServiceProcessException;

class BillController extends BaseController
{
    /**
     * @var \Vovo\Services\BillService
     */
    protected $billService;

    /**
     * BillController constructor.
     * @param \Vovo\Services\BillService $billService
     */
    public function __construct(BillService $billService)
    {
        $this->billService = $billService;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @throws Exception
     */
    public function store(Request $request)
    {
        $inputs = $request->all();

        $validator = Validator::make($inputs, BillSupport::CREATE_FIELD);
        try {
            if ($validator->fails()) {
                $messages   = $validator->getMessageBag()->messages();
                $message    = Arr::first(Arr::first($messages));
                throw new Exception($message);
            }

            $bill = $this->billService->create($inputs);
        } catch (ServiceProcessException $error) {
            $this->throwErrorStore($error->getMessage());
        }

        return $bill;
    }
}
