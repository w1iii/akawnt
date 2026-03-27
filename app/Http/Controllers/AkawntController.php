<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AkawntController extends Controller
{
    public function home()
    {
        return view('home');
    }

    public function affiliates()
    {
        return view('affiliates');
    }

    public function reports()
    {
        return view('reports');
    }
}
