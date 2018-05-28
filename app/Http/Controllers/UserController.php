<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Ordent\RamenRest\Controllers\RestController;
use Ordent\RamenAuth\Auth\AuthTrait;
use App\Http\Model\User;
use App\Http\Model\Role;
use Ordent\RamenRest\Requests\RestRequestFactory;
use Illuminate\Validation\ValidationException;
class UsersController extends RestController
{

    use AuthTrait;
    
    protected $model = "\App\Http\Model\User";
    protected $uri = "/users/";
    
}
