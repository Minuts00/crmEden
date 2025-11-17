<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->is_admin) {
            // Admin: vede tutti gli ordini
            $orders = Order::with('user')->orderBy('created_at')->paginate(50);
            return view('dashboard.admin', compact('orders'));
        } else {
            // Utente: vede solo i propri ordini
            $orders = Order::where('id_user', $user->id)->paginate(50);
            return view('dashboard.index', compact('orders'));
        }
    }
}
