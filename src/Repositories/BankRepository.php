<?php

namespace Vovo\Repositories;

use Vovo\Models\Bank;
use Prettus\Repository\Eloquent\BaseRepository;

class BankRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return Bank::class;
    }
}
