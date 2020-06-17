<?php

namespace Vovo\Transformer;

use Vovo\Models\Bill;
use League\Fractal\TransformerAbstract;

class BillTransformer extends TransformerAbstract
{
    public function transform(Bill $bill)
    {
        return [
            'id'            => $bill->id,
            'description'   => $bill->description,
            'value'         => $bill->value,
            'date'          => $bill->date,
            'bank_user_id'  => $bill->bank_user_id
        ];
    }
}
