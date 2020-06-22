<?php


namespace Vovo\Support;


class BillSupport
{
    const CREATE_FIELD = [
        'bank_user_id'  => 'required|int',
        'description'   => 'required|string',
        'date'          => 'required|string',
        'value'         => 'required|string'
    ];
}
