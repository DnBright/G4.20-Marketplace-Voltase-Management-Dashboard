<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function dashboard()
    {
        // Fetch products for inventory context
        $products = Product::latest()->take(10)->get();

        // If products are empty, let's show recent orders instead to make the dashboard look active
        $recentActivity = $products->isEmpty() ? Order::latest()->take(10)->get() : $products;

        // 1. Order Category Distribution (Top 5)
        $categories = Order::select('category', \DB::raw('count(*) as total'))
            ->groupBy('category')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        // 2. Order City Distribution (Top 5)
        $cities = Order::select('city', \DB::raw('count(*) as total'))
            ->groupBy('city')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        // 3. Order Price Range Distribution
        $priceRanges = [
            '< 50K' => Order::where('price', '<', 50000)->count(),
            '50K - 100K' => Order::whereBetween('price', [50000, 100000])->count(),
            '> 100K' => Order::where('price', '>', 100000)->count(),
        ];

        // 4. Stats
        $avgRating = Order::avg('rating') ?? 0;
        $totalOrders = Order::count();
        $totalSalesValuation = Order::sum('price');

        // 5. Income Dynamics (From Orders) - Last 6 Months
        $incomeData = Order::select(
            \DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
            \DB::raw('SUM(price) as total_income')
        )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // 6. Global Recommendations (Collaborative Filtering for Admin)
        $recommendationService = new \App\Services\RecommendationService();
        $globalRecommendations = $recommendationService->getGlobalTrendingProducts(6);
        $mostSoldProducts = $recommendationService->getMostSoldProducts(6);
        $topRatedProducts = $recommendationService->getTopRatedProducts(6);

        return view('admin.dashboard', compact(
            'products',
            'recentActivity',
            'categories',
            'cities',
            'priceRanges',
            'avgRating',
            'totalOrders',
            'totalSalesValuation',
            'incomeData',
            'globalRecommendations',
            'mostSoldProducts',
            'topRatedProducts'
        ));
    }

    public function show(Product $product)
    {
        return view('product.show', compact('product'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'category' => 'nullable',
            'description' => 'nullable',
            'image' => 'nullable|url', // Using URL for simplicity in this demo
        ]);

        Product::create($request->all());

        return redirect()->route('admin.dashboard')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
        ]);

        $product->update($request->all());

        return redirect()->route('admin.dashboard')->with('success', 'Produk berhasil diupdate.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.dashboard')->with('success', 'Produk berhasil dihapus.');
    }
}
