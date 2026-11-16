<?php

namespace App\Http\Controllers;

use App\Models\{Product, Market, User, Announcement, Category};
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $r)
    {
        $q = $r->string('q')->toString();
        $products = Product::with(['farmer', 'category', 'market'])->where('is_available', 1)->where('stock_quantity', '>', 0)->when($q, fn($x) => $x->where('name', 'like', '%' . $q . '%'))->latest()->take(8)->get();
        $markets = Market::where('is_active', 1)->latest()->take(4)->get();
        $farmers = User::where('role', 'farmer')->where('status', 'active')->whereHas('farmerProfile', fn($q) => $q->where('approval_status', 'approved'))->with('farmerProfile')->take(6)->get();
        $announcements = Announcement::where('is_active', 1)->latest()->take(3)->get();
        $categories = Category::orderBy('name')->get();
        return view('home', compact('products', 'markets', 'farmers', 'announcements', 'categories', 'q'));
    }

    public function markets()
    {
        $markets = Market::where('is_active', 1)->withCount('products')->orderBy('name')->get();
        return view('markets.index', compact('markets'));
    }

    public function dashboard()
    {
        return match (auth()->user()->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'farmer' => redirect()->route('farmer.dashboard'),
            default => redirect()->route('customer.dashboard'),
        };
    }
}
