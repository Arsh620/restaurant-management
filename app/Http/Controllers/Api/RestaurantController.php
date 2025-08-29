<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    public function index(Request $request)
    {
        $query = Restaurant::query();

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
                  ->orWhere('cuisine', 'like', "%{$search}%");
            });
        }

        // Filter by cuisine
        if ($request->has('cuisine')) {
            $query->where('cuisine', $request->cuisine);
        }

        // Filter by location
        if ($request->has('location')) {
            $query->where('location', $request->location);
        }

        // Sort
        $sortBy = $request->get('sort_by', 'name');
        $sortOrder = $request->get('sort_order', 'asc');
        $query->orderBy($sortBy, $sortOrder);

        // Pagination
        $perPage = $request->get('per_page', 10);
        $restaurants = $query->paginate($perPage);

        return response()->json($restaurants);
    }

    public function show($id)
    {
        $restaurant = Restaurant::with('orders')->findOrFail($id);
        return response()->json($restaurant);
    }
}
