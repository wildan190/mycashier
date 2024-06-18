<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboard()
    {
        // Monthly Sales Data
        $monthlySales = DB::table('transactions')
            ->select(
                DB::raw('YEAR(transaction_date) as year'),
                DB::raw('MONTH(transaction_date) as month'),
                DB::raw('SUM(total_price) as total_sales')
            )
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        $salesData = $monthlySales->map(function ($item) {
            return [
                'month' => $item->month . '-' . $item->year,
                'total_sales' => $item->total_sales,
            ];
        });

        // Products Sold Data
        $productsSold = Product::select('product_name', DB::raw('SUM(quantity) as total_sold'))
            ->join('product_transaction', 'products.id', '=', 'product_transaction.product_id')
            ->groupBy('product_name')
            ->orderBy('total_sold', 'desc')
            ->get();

        // Products Stock Data
        $productsStock = Product::select('product_name', 'product_stock')
            ->orderBy('product_stock', 'desc')
            ->get();

        // Categories Data
        $categories = Category::withCount('products')
            ->get();

        return response()->json([
            'salesData' => $salesData,
            'productsSold' => $productsSold,
            'productsStock' => $productsStock,
            'categories' => $categories,
        ]);
    }
}

