<?php

namespace App\Http\Controllers;

class Controller extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth');
    }
}
