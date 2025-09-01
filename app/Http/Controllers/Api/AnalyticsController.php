<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class AnalyticsController extends Controller
{
    public function orderTrends(Request $request, $restaurantId)
    {
        $startDate = $request->get('start_date', now()->subDays(7)->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->format('Y-m-d'));

        $trends = Order::where('restaurant_id', $restaurantId)
            ->whereBetween('order_time', [$startDate, $endDate])
            ->selectRaw('DATE(order_time) as date, 
                        COUNT(*) as daily_orders,
                        SUM(order_amount) as daily_revenue,
                        AVG(order_amount) as avg_order_value')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $peakHours = Order::where('restaurant_id', $restaurantId)
            ->whereBetween('order_time', [$startDate, $endDate])
            ->selectRaw('DATE(order_time) as date, 
                        EXTRACT(HOUR FROM order_time) as hour,
                        COUNT(*) as order_count')
            ->groupBy('date', 'hour')
            ->get()
            ->groupBy('date')
            ->map(function($dayOrders) {
                return $dayOrders->sortByDesc('order_count')->first();
            });

        return response()->json([
            'trends' => $trends,
            'peak_hours' => $peakHours
        ]);
    }

    public function topRestaurants(Request $request)
    {
        $startDate = $request->get('start_date', now()->subDays(7)->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->format('Y-m-d'));
        
        $cacheKey = "top_restaurants_{$startDate}_{$endDate}";
        
        $topRestaurants = Cache::remember($cacheKey, 300, function() use ($startDate, $endDate) {
            return Restaurant::select('restaurants.*')
                ->selectRaw('SUM(orders.order_amount) as total_revenue')
                ->join('orders', 'restaurants.id', '=', 'orders.restaurant_id')
                ->whereBetween('orders.order_time', [$startDate, $endDate])
                ->groupBy('restaurants.id')
                ->orderByDesc('total_revenue')
                ->limit(3)
                ->get();
        });

        return response()->json($topRestaurants);
    }

    public function filteredOrders(Request $request)
    {
        $query = Order::with('restaurant');

        if ($request->has('restaurant_id')) {
            $query->where('restaurant_id', $request->restaurant_id);
        }

        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('order_time', [$request->start_date, $request->end_date]);
        }

        if ($request->has('min_amount')) {
            $query->where('order_amount', '>=', $request->min_amount);
        }

        if ($request->has('max_amount')) {
            $query->where('order_amount', '<=', $request->max_amount);
        }

        if ($request->has('start_hour') && $request->has('end_hour')) {
            $query->whereRaw('EXTRACT(HOUR FROM order_time) BETWEEN ? AND ?', [$request->start_hour, $request->end_hour]);
        }

        $orders = $query->paginate($request->get('per_page', 15));

        return response()->json($orders);
    }
}
