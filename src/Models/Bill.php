<?php

namespace Vovo\Models;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $fillable = [
        'date',
        'value',
        'description',
        'bank_user_id',
    ];
}
