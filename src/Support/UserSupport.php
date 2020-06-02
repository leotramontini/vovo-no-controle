<?php

namespace Vovo\Support;

class UserSupport
{
    /**
     * @const array
     */
    const CREATE_FIELD = [
        'name'      => 'required|string',
        'email'     => 'required|string',
        'password'  => 'required|string'
    ];
}
