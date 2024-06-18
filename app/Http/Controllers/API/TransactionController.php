<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Http\Request;
use PDF;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::orderBy('created_at', 'desc')->paginate(10);
        return $transactions;
    }

    public function create()
    {
        $customers = Customer::all();
        $products = Product::where('product_stock', '>', 0)->paginate(10);
        return [
            'customers' => $customers,
            'products' => $products,
        ];
    }

    public function store(Request $request)
    {
        $this->validateTransaction($request);

        $transaction = $this->createTransaction($request);

        $this->updateProductStock($request, $transaction);

        $this->createTransactionItems($request, $transaction);

        return $transaction;
    }

    public function print(Transaction $transaction)
    {
        $pdf = PDF::loadView('transactions.print', compact('transaction'))
            ->setPaper('a7', 'portrait');

        return response($pdf->download('transaction_receipt.pdf'));
    }

    private function validateTransaction(Request $request)
    {
        $request->validate([
            'customers_id' => 'required|exists:customers,id',
            'transaction_date' => 'required|date',
            'products' => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);
    }

    private function createTransaction(Request $request)
    {
        return Transaction::create([
            'customers_id' => $request->customers_id,
            'transaction_number' => uniqid(),
            'transaction_date' => $request->transaction_date,
            'transaction_year' => date('Y', strtotime($request->transaction_date)),
        ]);
    }

    private function updateProductStock(Request $request, Transaction $transaction)
    {
        foreach ($request->products as $product) {
            $productData = Product::find($product['id']);
            $quantity = $product['quantity'];

            $productData->product_stock -= $quantity;
            $productData->save();

            $transaction->products()->attach($product['id'], ['quantity' => $quantity, 'customers_id' => $transaction->customers_id]);
        }
    }

    private function createTransactionItems(Request $request, Transaction $transaction)
    {
        $totalPrice = 0;

        foreach ($request->products as $product) {
            $productData = Product::find($product['id']);
            $quantity = $product['quantity'];
            $price = $productData->price;

            $totalPrice += $price * $quantity;
        }

        $transaction->total_price = $totalPrice;
        $transaction->save();
    }

}