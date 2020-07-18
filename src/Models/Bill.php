<?php

namespace Vovo\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bill extends Model
{
    use SoftDeletes;

    /**
     * @var array
     */
    protected $fillable = [
        'date',
        'value',
        'description',
        'bank_user_id',
    ];
}
