<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Illuminate\Support\Facades\Redis;

class redisController extends Controller
{

    public function index() {
        Redis::get('user:profile:');
    }
    //
}
