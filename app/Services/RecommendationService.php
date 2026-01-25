<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class RecommendationService
{
    /**
     * Get recommendations for a specific user using User-Based Collaborative Filtering.
     */
    public function getRecommendations($userId, $limit = 5)
    {
        // 1. Get all orders to build the user-item matrix
        $orders = Order::all();

        // 2. Build User-Item Matrix (Rating/Interest)
        // Since we only have "purchases", we'll treat each purchase as a "5.0" rating or use the actual rating if available.
        $matrix = [];
        $allProducts = [];
        foreach ($orders as $order) {
            $matrix[$order->user_id][$order->product_name] = (float) $order->rating;
            $allProducts[$order->product_name] = true;
        }

        if (!isset($matrix[$userId])) {
            return $this->getPopularProducts($limit);
        }

        // 3. Find similar users using Cosine Similarity
        $userRatings = $matrix[$userId];
        $similarities = [];
        foreach ($matrix as $otherId => $otherRatings) {
            if ($otherId == $userId)
                continue;
            $similarities[$otherId] = $this->calculateCosineSimilarity($userRatings, $otherRatings);
        }

        // 4. Sort similarities and pick top N neighbors
        arsort($similarities);
        $neighbors = array_slice($similarities, 0, 10, true);

        // 5. Predict scores for products the target user hasn't bought
        $predictions = [];
        foreach (array_keys($allProducts) as $productName) {
            if (isset($userRatings[$productName]))
                continue;

            $scoreSum = 0;
            $simSum = 0;

            foreach ($neighbors as $neighborId => $sim) {
                if (isset($matrix[$neighborId][$productName])) {
                    $scoreSum += $sim * $matrix[$neighborId][$productName];
                    $simSum += abs($sim);
                }
            }

            if ($simSum > 0) {
                $predictions[$productName] = $scoreSum / $simSum;
            }
        }

        arsort($predictions);
        $topProducts = array_slice($predictions, 0, $limit, true);

        // Map product names back to some structure (or just return names)
        return $this->formatRecommendations($topProducts);
    }

    /**
     * Admin POV: Get products with the highest potential interest (Collaborative Filtering Score).
     * This is calculated by aggregating predicted ratings across all users.
     */
    public function getGlobalTrendingProducts($limit = 6)
    {
        $orders = Order::all();
        $matrix = [];
        $allProducts = [];
        foreach ($orders as $order) {
            $matrix[$order->user_id][$order->product_name] = (float) $order->rating;
            $allProducts[$order->product_name] = true;
        }

        $globalScores = [];
        foreach (array_keys($allProducts) as $productName) {
            $count = 0;
            $totalRating = 0;
            foreach ($matrix as $userId => $ratings) {
                if (isset($ratings[$productName])) {
                    $totalRating += $ratings[$productName];
                    $count++;
                }
            }
            $globalScores[$productName] = ($totalRating / $count) * log($count + 1);
        }

        arsort($globalScores);
        $topProducts = array_slice($globalScores, 0, $limit, true);
        return $this->formatRecommendations($topProducts);
    }

    /**
     * Get products with the highest sales volume.
     */
    public function getMostSoldProducts($limit = 6)
    {
        $stats = Order::select('product_name', DB::raw('COUNT(*) as total_sales'))
            ->groupBy('product_name')
            ->orderByDesc('total_sales')
            ->limit($limit)
            ->pluck('total_sales', 'product_name')
            ->toArray();

        return $this->formatRecommendations($stats);
    }

    /**
     * Get products with the highest average rating.
     */
    public function getTopRatedProducts($limit = 6)
    {
        $stats = Order::select('product_name', DB::raw('AVG(rating) as avg_rating'))
            ->groupBy('product_name')
            ->orderByDesc('avg_rating')
            ->limit($limit)
            ->pluck('avg_rating', 'product_name')
            ->toArray();

        return $this->formatRecommendations($stats);
    }

    private function calculateCosineSimilarity($u1, $u2)
    {
        $commonKeys = array_intersect(array_keys($u1), array_keys($u2));
        if (empty($commonKeys))
            return 0;

        $dotProduct = 0;
        $norm1 = 0;
        $norm2 = 0;

        foreach ($u1 as $val)
            $norm1 += $val * $val;
        foreach ($u2 as $val)
            $norm2 += $val * $val;
        foreach ($commonKeys as $key)
            $dotProduct += $u1[$key] * $u2[$key];

        $denominator = sqrt($norm1) * sqrt($norm2);
        return $denominator == 0 ? 0 : $dotProduct / $denominator;
    }

    private function getPopularProducts($limit)
    {
        return Order::select('product_name', 'category', 'price', DB::raw('AVG(rating) as avg_rating'), DB::raw('COUNT(*) as total_sales'))
            ->groupBy('product_name', 'category', 'price')
            ->orderByDesc('total_sales')
            ->orderByDesc('avg_rating')
            ->limit($limit)
            ->get();
    }

    private function formatRecommendations($predictions)
    {
        $result = [];
        foreach ($predictions as $name => $score) {
            // Find one sample order to get category and price
            $sample = Order::where('product_name', $name)->first();
            if ($sample) {
                $result[] = (object) [
                    'product_name' => $name,
                    'category' => $sample->category,
                    'price' => $sample->price,
                    'city' => $sample->city,
                    'ai_score' => $score,
                    'rating' => $sample->rating
                ];
            }
        }
        return $result;
    }
}
