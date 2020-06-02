<?php

namespace Vovo\Controllers;

use Validator;
use Illuminate\Http\Request;
use Vovo\Support\UserSupport;
use Vovo\Services\UserService;
use Vovo\Transformer\UserTransformer;
use Vovo\Exceptions\ServiceProcessException;

class UserController extends BaseController
{
    /**
     * @var Vovo\Services\UserService;
     */
    protected $userService;

    /**
     * @param \Vovo\Services\UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $inputs = $request->all();

        $validator = Validator::make($inputs, UserSupport::CREATE_FIELD);

        if ($validator->fails()) {
            $this->throwErrorBadRequest();
        }

        try {
            $user = $this->userService->store($inputs);
            return $this->item($user, new UserTransformer());
        } catch (ServiceProcessException $error) {
            $this->throwErrorStore($error->getMessage());
        }
    }
}
