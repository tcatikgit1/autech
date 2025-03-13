<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class WebController extends Controller
{
    public function index()
    {
        return view(view: 'home.index');
    }
}
