<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Ordent\RamenRest\Controllers\RestController;
use Ordent\RamenAuth\Auth\AuthTrait;
use App\Http\Model\User;

class UserController extends RestController
{

    use AuthTrait;
    
    protected $model = "\App\Http\Model\User";
    protected $uri = "/accounts/";
    
}
