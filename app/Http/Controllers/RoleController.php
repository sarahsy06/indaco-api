<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\Request;
use Ordent\RamenRest\Controllers\RestController;

class RoleController extends RestController
{
    protected $model = "\App\Http\Model\Role";
    protected $uri = "/roles/";
}
