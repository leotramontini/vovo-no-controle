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
     * @throws \Vovo\Exceptions\ServiceProcessException
     */
    public function store($inputs)
    {
        try {
            return $this->userRepository->create($inputs);
        } catch (Exception $error) {
            throw new ServiceProcessException($error->getMessage());
        }
    }

    /**
     * @param array $inputs
     * @param int $userId
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Support\Collection|mixed
     * @throws \Vovo\Exceptions\ServiceProcessException
     */
    public function update($inputs, $userId)
    {
        try {
            return $this->userRepository->update($inputs, $userId);
        } catch (Exception $error) {
            throw new ServiceProcessException($error->getMessage());
        }
    }
}
