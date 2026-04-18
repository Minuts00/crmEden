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
   
 public function create()
{
    $this->authorize('create', Order::class);
    $products = \App\Models\Product::all();
    return view('orders.create', compact('products'));
}

public function store(Request $request)
{
    // dd($request->all());
    if (!Auth::check()) {
        $this->authorize('create', Order::class);
        return redirect()->route('login')->withErrors('Devi essere autenticato per inviare un ordine.');
    }

    $validated = $request->validate([
        'product_id' => 'required|exists:products,id',
        'description' => 'nullable|string',
        'price' => 'required|numeric',
        'payment_proof' => 'nullable|image|max:2048',
    ]);
    //dd($validated);

    $order = new Order();
$order->id_user = Auth::id();
$order->product_id = $request->input('product_id');
$order->description = $request->input('description');
$order->price = $request->input('price');

    if ($request->hasFile('payment_proof')) {
        $path = $request->file('payment_proof')->store('payment_proofs', 'public');
        $order->payment_proof = $path;
    }
    //dd($order);
   $order->save();
   //if (!$order->exists) {
 //  dd('Ordine NON salvato', $order);
   //}

   return redirect()->route('orders.create')->with('success', 'Ordine inviato con successo.');
}
public function show($id)
{
    $order = Order::findOrFail($id);
    $this->authorize('view', $order);
    return view('orders.show', compact('order'));
}
}
