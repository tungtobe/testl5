<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseControllers;
use Illuminate\Foundation\Validation\ValidatesRequests;

abstract class Controller extends BaseControllers
{
    use DispatchesJobs, ValidatesRequests;
}
