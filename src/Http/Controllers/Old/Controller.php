<?php namespace Mrcore\Auth\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ControllerOLD extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
