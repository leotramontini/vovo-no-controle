<?php

namespace Vovo\Repositories;

use Vovo\Models\Bill;
use Prettus\Repository\Eloquent\BaseRepository;

class BillRepository extends BaseRepository
{
    public function model()
    {
        return Bill::class;
    }
}
