<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Userorder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class User_Controller extends Controller
{
     public function __construct()
    {

        //last work point, rielaborare per orders (lista ordini fatti)
    }

    //   public function ordersDone()
    // {
    //     $prodotti = ProdottoAcquistato::whereIn('id_prodotto', Prodotto::where('id_utente', '=', Auth::user()->ID)->get()->pluck('ID')->toArray())->get();
    //     return view('prodotti-venduti', ['prodotti' => $prodotti]);
    // } TRALASCIATO PERCHÉ FUORI LOGICA ATTUALE (BETA 0.1)
    public function dashboard()
    {
        return view('dashboard');
    }
}
