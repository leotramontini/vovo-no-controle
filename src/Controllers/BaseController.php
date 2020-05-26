<?php

namespace Vovo\Controllers;

use Dingo\Api\Routing\Helpers;
use Illuminate\Routing\Controller;
use Vovo\Controllers\Traits\MakesResponses;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class BaseController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, MakesResponses, Helpers;
}
