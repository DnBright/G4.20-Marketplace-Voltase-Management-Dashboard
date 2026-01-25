<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::query();

        // Filter by Month
        if ($request->filled('month')) {
            $query->whereRaw('DATE_FORMAT(created_at, "%Y-%m") = ?', [$request->month]);
        }

        // Filter by Category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Filter by Price Range
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        $orders = $query->latest()->paginate(15)->withQueryString();

        // Data for Filters
        $categories = Order::distinct()->pluck('category');
        $months = Order::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month')
            ->distinct()
            ->orderBy('month', 'desc')
            ->pluck('month');

        $recommendationService = new \App\Services\RecommendationService();
        $userRecommendations = $recommendationService->getRecommendations(auth()->id(), 4);

        return view('admin.orders.index', compact('orders', 'categories', 'months', 'userRecommendations'));
    }

    public function export(Request $request)
    {
        $query = Order::query();

        // Apply same filters as index
        if ($request->filled('month')) {
            $query->whereRaw('DATE_FORMAT(created_at, "%Y-%m") = ?', [$request->month]);
        }
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        $orders = $query->latest()->get();

        $filename = "orders_export_" . date('Y-m-d_H-i-s') . ".csv";
        $handle = fopen('php://output', 'w');

        // Headers for the browser
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        // CSV Header row
        fputcsv($handle, ['Order ID', 'Product Name', 'Category', 'Price', 'City', 'Rating', 'Date']);

        // CSV Data rows
        foreach ($orders as $order) {
            fputcsv($handle, [
                $order->id,
                $order->product_name,
                $order->category,
                $order->price,
                $order->city,
                $order->rating,
                $order->created_at->format('Y-m-d H:i:s'),
            ]);
        }

        fclose($handle);
        exit;
    }

    public function create()
    {
        return view('admin.orders.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'price' => 'required|numeric',
            'city' => 'required|string|max:255',
            'rating' => 'required|numeric|min:0|max:5',
        ]);

        Order::create($request->all());

        return redirect()->route('admin.orders.index')->with('success', 'Order berhasil ditambahkan.');
    }

    public function edit(Order $order)
    {
        return view('admin.orders.edit', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'price' => 'required|numeric',
            'city' => 'required|string|max:255',
            'rating' => 'required|numeric|min:0|max:5',
        ]);

        $order->update($request->all());

        return redirect()->route('admin.orders.index')->with('success', 'Order berhasil diupdate.');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('admin.orders.index')->with('success', 'Order berhasil dihapus.');
    }
}
