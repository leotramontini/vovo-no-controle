<?php

namespace Vovo\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bank extends Model
{
    use SoftDeletes;

    /**
     * @var array
     */
    protected $fillable = [
        'name'
    ];
}
