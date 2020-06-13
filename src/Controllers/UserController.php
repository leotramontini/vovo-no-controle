<?php

namespace Vovo\Controllers;

use Validator;
use Illuminate\Http\Request;
use Vovo\Support\UserSupport;
use Vovo\Requests\UserRequest;
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
     * @param \Vovo\Requests\UserRequest $request
     * @return mixed
     */
    public function store(UserRequest $request)
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
     * @param \Vovo\Requests\UserRequest $request
     * @param int $userId
     * @return mixed
     */
    public function update(UserRequest $request, $userId)
    {
        $inputs = $request->all();

        try {
            $user = $this->userService->update($inputs, $userId);
        } catch (ServiceProcessException $error) {
            $this->throwErrorUpdate($error->getMessage());
        }

        return $this->item($user, new UserTransformer());
    }

    /**
     * @param int $userId
     * @return mixed
     */
    public function delete($userId)
    {
        try {
            $this->userService->delete($userId);
        } catch (ServiceProcessException $error) {
            $this->throwErrorDelete($error->getMessage());
        }

        return $this->array([
            'data' => [
                'message' => 'User was delete with success'
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
            $user = $this->userService->index($request->all());
            return $this->collection($user, new UserTransformer());
        } catch (ServiceProcessException $error) {
            $this->throwErrorNotFound($error->getMessage());
        }
    }
}
