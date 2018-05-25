<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Ordent\RamenRest\Controllers\RestController;

class ProjectController extends RestController
{
    protected $model = "\App\Http\Model\Project";
    protected $uri = "/projects/";
}
