<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function monthlyReport(Request $request)
    {
        // Ambil tahun dan bulan dari permintaan, default ke bulan ini
        $year = $request->input('year', date('Y'));
        $month = $request->input('month', date('m'));

        // Ambil transaksi untuk bulan dan tahun yang dipilih
        $transactions = Transaction::whereYear('transaction_date', $year)
            ->whereMonth('transaction_date', $month)
            ->get();

        // Hitung total penjualan bulanan
        $monthlySales = $transactions->sum('total_price');

        return response()->json([
            'transactions' => $transactions,
            'monthlySales' => $monthlySales,
            'year' => $year,
            'month' => $month
        ]);
    }

    public function productReport(Request $request)
    {
        $productSales = DB::table('product_transaction')
            ->join('products', 'product_transaction.product_id', '=', 'products.id')
            ->select('products.product_name', DB::raw('SUM(product_transaction.quantity) as total_sold'), DB::raw('SUM(product_transaction.quantity * products.price) as total_sales_value'))
            ->groupBy('products.product_name')
            ->get();

        $remainingProducts = Product::select('product_name', 'product_stock')
            ->get();

        return response()->json([
            'productSales' => $productSales,
            'remainingProducts' => $remainingProducts
        ]);
    }
}

