<?php

namespace Vovo\Repositories;

use Vovo\Models\BankUser;
use Prettus\Repository\Eloquent\BaseRepository;

class BankUserRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return BankUser::class;
    }
}
