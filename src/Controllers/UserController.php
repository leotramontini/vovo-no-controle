<?php

namespace Vovo\Controllers;

use Validator;
use Exception;
use Illuminate\Support\Arr;
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

        try {
            if ($validator->fails()) {
                $messages   = $validator->getMessageBag()->messages();
                $message    = Arr::first(Arr::first($messages));
                throw new Exception($message);
            }

            $user = $this->userService->store($inputs);
        } catch (Exception $error) {
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
        } catch (ServiceProcessException $error) {
            $this->throwErrorNotFound($error->getMessage());
        }
        return $this->collection($user, new UserTransformer());
    }
}
