<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExampleController extends Controller
{
    public function example()
    {
        return view('admin.pages.dashboard');
    }
    public function products()
    {
        return view('admin.pages.products.list');
    }
}
