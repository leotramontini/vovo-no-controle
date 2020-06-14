<?php

namespace Vovo\Transformer;

use Vovo\Models\BankUser;
use League\Fractal\TransformerAbstract;

class BankUserTransformer extends TransformerAbstract
{
    /**
     * @param \Vovo\Models\UserBank $userBank
     * @return array
     */
    public function transform(BankUser $userBank)
    {
        return [
            'id'        => $userBank->id,
            'user_id'   => $userBank->user_id,
            'bank_id'   => $userBank->bank_id
        ];
    }
}
