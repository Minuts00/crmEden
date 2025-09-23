<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use App\Models\Product; 
use Illuminate\Http\Request;

class Home_Controller extends Controller
{
       public function __construct()
     {
        $this->middleware('auth');
    }

     public function index()
    {
    $products = Product::all();
    return view('home', compact('products'));
}
}
