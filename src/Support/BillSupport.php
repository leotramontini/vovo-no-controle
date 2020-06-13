<?php


namespace Vovo\Support;


class BillSupport
{
    const CREATE_FIELD = [
        'user_bank_id'  => 'required|int',
        'description'   => 'required|string',
        'date'          => 'required|string',
        'value'         => 'required|float'
    ];
}
