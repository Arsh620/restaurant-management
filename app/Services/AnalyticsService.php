<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Restaurant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class AnalyticsService
{
    public function getRestaurantTrends($restaurantId, $startDate, $endDate)
    {
        $cacheKey = "trends_{$restaurantId}_{$startDate}_{$endDate}";
        
        return Cache::remember($cacheKey, 300, function() use ($restaurantId, $startDate, $endDate) {
            return DB::select("
                SELECT 
                    DATE(order_time) as date,
                    COUNT(*) as daily_orders,
                    SUM(order_amount) as daily_revenue,
                    AVG(order_amount) as avg_order_value
                FROM orders 
                WHERE restaurant_id = ? 
                AND order_time BETWEEN ? AND ?
                GROUP BY DATE(order_time)
                ORDER BY date
            ", [$restaurantId, $startDate, $endDate]);
        });
    }

    public function getPeakHours($restaurantId, $startDate, $endDate)
    {
        return DB::select("
            SELECT 
                DATE(order_time) as date,
                HOUR(order_time) as peak_hour,
                COUNT(*) as order_count
            FROM orders 
            WHERE restaurant_id = ? 
            AND order_time BETWEEN ? AND ?
            GROUP BY DATE(order_time), HOUR(order_time)
        ", [$restaurantId, $startDate, $endDate]);
    }
}