<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class MainController extends Controller
{
    /**
     * @return View
     */
    public function __invoke()
    {
        return view('index');
    }
}
