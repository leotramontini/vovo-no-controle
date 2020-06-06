<?php

namespace Vovo\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;

/**
 * Class UserRequest
 * @package Vovo\Requests
 * @codeCoverageIgnore
 */
class UserRequest extends FormRequest
{
    /**
     * @param null $key
     * @return array
     */
    public function all($key = null)
    {
        $inputs = parent::all($key);

        $password = Arr::get($inputs,'password', null);

        if (!is_null($password)) {
            Arr::set($inputs, 'password', bcrypt($password));
        }
        return $inputs;
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [];
    }
}
