<?php

namespace Vovo\Controllers;

use Validator;
use Illuminate\Http\Request;
use Vovo\Models\User;
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
        } catch (ServiceProcessException $error) {
            $this->throwErrorStore($error->getMessage());
        }
        return $this->item($user, new UserTransformer());
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param int $userId
     * @return mixed
     */
    public function update(Request $request, $userId)
    {
        $inputs = $request->all();

        try {
            $user = $this->userService->update($inputs, $userId);
        } catch (ServiceProcessException $error) {
            $this->throwErrorUpdate($error->getMessage());
        }

        return $this->item($user, new UserTransformer());
    }
}
