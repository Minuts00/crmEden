<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

     public function admin()
    {
        $orders = Order::with('user')->orderBy('created_at')->paginate(50);

        return view('dashboard.admin', compact('orders'));
    }

    public function index()
    {
        $user = Auth::user();

        if ($user->is_admin) {
        return $this->admin();
        } else {
            // Utente: vede solo i propri ordini
            $orders = Order::where('id_user', $user->id)->paginate(50);
            return view('dashboard.index', compact('orders'));
        }
    }
}
