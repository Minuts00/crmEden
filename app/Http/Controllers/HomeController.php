<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
     public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
         $products = \App\Models\Product::all();
    return view('home', compact('products'));
    }
}
