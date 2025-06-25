<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
     public function __construct()
    {

    }
    // da riscrivere TUTTO secondo orders
   
    public function create()
{
    return view('orders.create');
}

public function store(Request $request)
{
    // dd($request->all());
    if (!Auth::check()) {
        return redirect()->route('login')->withErrors('Devi essere autenticato per inviare un ordine.');
    }

    $validated = $request->validate([
        'name' => 'required|string',
        'description' => 'nullable|string',
        'price' => 'required|numeric',
        'payment_proof' => 'nullable|image|max:2048',
    ]);

    $order = new Order();
$order->id_user = Auth::id();
$order->name = $request->input('name');
$order->description = $request->input('description');
$order->price = $request->input('price');

    if ($request->hasFile('payment_proof')) {
        $path = $request->file('payment_proof')->store('payment_proofs', 'public');
        $order->payment_proof = $path;
    }
// dd($order);
    $order->save();

    return redirect()->route('orders.create')->with('success', 'Ordine inviato con successo.');
}
}
