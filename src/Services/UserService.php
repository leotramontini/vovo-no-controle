<?php

namespace Vovo\Services;

use Exception;
use Illuminate\Support\Arr;
use Vovo\Repositories\UserRepository;
use Vovo\Exceptions\ServiceProcessException;

class UserService
{
    /**
     * @var \Vovo\Repositories\UserRepository
     */
    protected $userRepository;

    /**
     * UserService contruct
     *
     * @param \Vovo\Repositories\UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param array $inputs
     * @return \Vovo\Models\User
     */
    public function store($inputs)
    {
        try {
            $password = Arr::get($inputs,'password');
            Arr::set($inputs, 'password',  bcrypt($password));
            return $this->userRepository->create($inputs);
        } catch (Exception $error) {
            throw new ServiceProcessException($error->getMessage());
        }
    }
}
