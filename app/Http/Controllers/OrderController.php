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
    $users = User::all(); // così puoi selezionare l'utente dal form
    return view('orders.create', compact('users'));
}

public function store(Request $request)
{
   $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'price' => 'required|numeric',
        'payment_proof' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    $order = new Order();
    $order->id_user = Auth::id();
    $order->name = $validated['name'];
    $order->description = $validated['description'];
    $order->price = $validated['price'];

    // Caricamento immagine se presente
    if ($request->hasFile('payment_proof')) {
        $path = $request->file('payment_proof')->store('payment_proofs', 'public');
        $order->payment_proof = $path;
    }

    $order->save();

    return redirect()->route('orders.index')->with('success', 'Ordine inviato con successo.');
if (!Auth::check()) {
    return redirect()->route('login')->withErrors('Devi essere autenticato per inviare un ordine.');
}
}
}
