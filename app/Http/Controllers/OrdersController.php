<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrdersController extends Controller
{
     public function __construct()
    {

    }
    // da riscrivere TUTTO secondo orders
    public function all()
    {
        $orders = Order::all();
        return view('dashboard', compact('orders'));
    }

     public function postOrder(Request $request)
    {
        try
        {
            $data = Validator::make($request->post(), [
                'name' => ['required', 'min:3', 'string'],
                'price' => ['required', 'between:0,99999.99'],
                'description' => ['required'],
                ])->validate();

            // metodo save
            // $prodotto = new Prodotto();

            // $prodotto->nome = $data['nome'];
            // $prodotto->prezzo = $data['prezzo'];
            // $prodotto->descrizione = $data['descrizione'];
            // $prodotto->stock = $data['stock'];
            // $prodotto->immagine = $request->file('img') ? $request->file('img')->store('public/media') : '/media/default.webp';
            // $prodotto->id_categoria = $data['categoria'];
            // $prodotto->id_utente = auth()->user()->ID;

            // $prodotto->save();
            // metodo PMA 
            $order = Order::create([
                'name'->$request->name,
                'price'->$request->price,
                'description'->$request->description,
                'id_user'->Auth::id(),
            ]);

            return to_route('orderSent', ['ID' => $order->ID]);
        } catch (ValidationException $e)
        {
            return
                to_route('postOrder')
                    ->withErrors($e->errors());
        }
    }
}
