<?php

namespace Vovo\Models;

use Illuminate\Database\Eloquent\Model;

class BankUser extends Model
{
    /**
     * @var array
     */
    public $fillable = [
        'bank_id',
        'user_id',
        'balance'
    ];
}
