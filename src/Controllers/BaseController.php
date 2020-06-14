<?php

namespace Vovo\Controllers;

use Dingo\Api\Routing\Helpers;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Vovo\Controllers\Traits\MakesResponses;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

/**
 * Class BaseController
 * @package Vovo\Controllers
 * @codeCoverageIgnore
 */
class BaseController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, MakesResponses, Helpers;

    /**
     * Captura o usuário logado
     *
     * @return \Vovo\Models\User
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function loggedUser()
    {
        if (! Auth::check()) {
            $this->response->errorForbidden('Unauthorized user');
        }

        return Auth::user();
    }

}
