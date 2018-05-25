<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Ordent\RamenRest\Controllers\RestController;

class PointController extends RestController
{
    protected $model = "\App\Http\Model\Point";
    protected $uri = "/points/";
}
