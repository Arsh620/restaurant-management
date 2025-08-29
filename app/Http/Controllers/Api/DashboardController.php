<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function overview(Request $request)
    {
        $startDate = $request->get('start_date', now()->subDays(7)->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->format('Y-m-d'));
        
        $cacheKey = "dashboard_overview_{$startDate}_{$endDate}";
        
        $data = Cache::remember($cacheKey, 300, function() use ($startDate, $endDate) {
            return [
                'total_revenue' => Order::whereBetween('order_time', [$startDate, $endDate])->sum('order_amount'),
                'total_orders' => Order::whereBetween('order_time', [$startDate, $endDate])->count(),
                'avg_order_value' => Order::whereBetween('order_time', [$startDate, $endDate])->avg('order_amount'),
                'active_restaurants' => Restaurant::whereHas('orders', function($q) use ($startDate, $endDate) {
                    $q->whereBetween('order_time', [$startDate, $endDate]);
                })->count(),
                'growth_rate' => $this->calculateGrowthRate($startDate, $endDate)
            ];
        });
        
        return response()->json($data);
    }
    
    private function calculateGrowthRate($startDate, $endDate)
    {
        $currentRevenue = Order::whereBetween('order_time', [$startDate, $endDate])->sum('order_amount');
        $previousRevenue = Order::whereBetween('order_time', [
            now()->parse($startDate)->subDays(7)->format('Y-m-d'),
            now()->parse($endDate)->subDays(7)->format('Y-m-d')
        ])->sum('order_amount');
        
        return $previousRevenue > 0 ? (($currentRevenue - $previousRevenue) / $previousRevenue) * 100 : 0;
    }
}