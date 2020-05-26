<?php

namespace Vovo\Transformer;

use Vovo\Models\Bank;
use League\Fractal\TransformerAbstract;

class BankTransformer extends TransformerAbstract
{
    /**
     * @param \Vovo\Models\Bank $bank
     * @return array
     */
    public function transform(Bank $bank)
    {
        return [
            'id'    => $bank->id,
            'name'  => $bank->name
        ];
    }
}
