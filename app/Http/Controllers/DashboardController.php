<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;

class DashboardController extends Controller
{
     public function index()
    {
        $totalOrders = Order::count();
        $totalRevenue = Order::sum('price');
        $ordersPerUser = User::withCount('orders')->get();
        $latestOrders = Order::with('user')->orderBy('created_at', 'desc')->limit(5)->get();

        return view('dashboard.index', compact(
            'totalOrders', 
            'totalRevenue', 
            'ordersPerUser', 
            'latestOrders'
        ));
    }
}
