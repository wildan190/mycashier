<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Product;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;
use PDF;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::orderBy('created_at', 'desc')->paginate(10);
        return view('transactions.index', compact('transactions'));
    }

    public function create()
    {
        $products = Product::where('product_stock', '>', 0)->paginate(10);
        return view('transactions.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'transaction_date' => 'required|date',
            'products' => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        $transaction = Transaction::create([
            'transaction_number' => uniqid(),
            'transaction_date' => $request->transaction_date,
            'transaction_year' => date('Y', strtotime($request->transaction_date)),
        ]);

        $totalPrice = 0;

        foreach ($request->products as $product) {
            $productData = Product::find($product['id']);
            $quantity = $product['quantity'];
            $price = $productData->price;
            $totalPrice += $price * $quantity;

            // Mengurangi jumlah produk dari stok
            $productData->product_stock -= $quantity;
            $productData->save();

            // Menambahkan relasi antara transaksi dan produk
            $transaction->products()->attach($product['id'], ['quantity' => $quantity]);
        }

        $transaction->total_price = $totalPrice;
        $transaction->save();

        // Konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        Config::$isProduction = config('midtrans.is_production');
        // Set sanitization on (default)
        Config::$isSanitized = config('midtrans.is_sanitized');
        // Set 3DS transaction for credit card to true
        Config::$is3ds = config('midtrans.is_3ds');

        $params = [
            'transaction_details' => [
                'order_id' => $transaction->id . "-" . date('Ymdhis'), // tambahkan tanggal dan waktu untuk memastikan order_id unik
                'gross_amount' => $transaction->total_price,
            ],
        ];

        // Buat token Snap menggunakan parameter yang telah dikonfigurasi
        $snapToken = Snap::getSnapToken($params);

        // Kembalikan respons dengan token Snap
        return view('transactions.snap')->with('snapToken', $snapToken);

    }

    public function print(Transaction $transaction)
    {
        $pdf = PDF::loadView('transactions.print', compact('transaction'))->setPaper('a7', 'portrait');

        return $pdf->download('transaction_receipt.pdf');
    }
}
