<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class BuyerController extends Controller
{
    /**
     * Show the buyer dashboard.
     */
    public function index()
    {
        $products = Product::latest()->get();
        return view('buyer.dashboard', compact('products'));
    }
}
