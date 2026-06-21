<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Order;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'totalProducts'   => Product::count(),
            'totalOrders'     => Order::count(),
            'pendingOrders'   => Order::where('status', 'pending')->count(),
            'totalRevenue'    => Order::whereNotIn('status', ['cancelled'])->sum('total'),
            'unreadMessages'  => ContactMessage::where('is_read', false)->count(),
            'recentOrders'    => Order::latest()->limit(5)->get(),
            'recentMessages'  => ContactMessage::latest()->limit(5)->get(),
        ]);
    }
}
