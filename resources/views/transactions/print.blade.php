<!-- resources/views/transactions/print.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=58mm">
    <title>Receipt</title>
    <style>
        body {
            font-family: Consolas, monospace;
            width: 58mm; /* Lebar struk */
            padding: 0px;
            font-size: 10px;
            line-height: 15px;
            color: #000; /* Warna text hitam */
            display: flex;
            flex-direction: column;
            justify-content: center;
            text-align: center;
        }
        .header {
            font-size: 1.5em;
            margin-bottom: 10px;
            border-bottom: 1px solid #000;
        }
        .transaction-info {
            font-size: 1.3em;
            margin-bottom: 10px;
            border-bottom: 1px solid #000;
        }
        .product-list {
            font-size: 1.3em;
            margin-bottom: 10px;
            border-bottom: 1px solid #000;
        }
        .product-list ul {
            list-style-type: none;
            padding: 0;
        }
        .product-list li {
            margin-bottom: 5px;
            padding-bottom: 5px;
            border-bottom: 1px dotted #000;
        }
        .total {
            font-size: 1.5em;
            font-weight: bold;
            margin-bottom: 10px;
            border-bottom: 1px solid #000;
        }
        .address {
            font-size: 1em;
            margin-bottom: 10px;
        }
        .footer {
            font-size: 1em;
        }
    </style>
</head>
<body>
    <div class="header">
        Minimarket
    </div>
    <div class="address">
        Jl. Minimarket, Kp. Kadu hejo, RT/RW 00/00, 4221, Jakarta Barat, DKI Jakarta
    </div>
    <div class="transaction-info">
        Transaction Number: {{ $transaction->transaction_number }}
        <br>
        Date: {{ $transaction->transaction_date }}
    </div>
    <div class="product-list">
        Products:
        <ul>
            @foreach ($transaction->products as $product)
            <li>{{ $product->product_name }} - {{ $product->pivot->quantity }} x {{ 'Rp. ' . number_format($product->price, 2) }} (PPN 11%) = {{ 'Rp. ' . number_format($product->price * 1.11, 2, ',', '.') }}</li>
            @endforeach
        </ul>
    </div>
    <div class="total">
        Total: Rp. {{ number_format($transaction->total_price, 2, ',', '.') }}
    </div>
    <div class="footer">
        Thank you for shopping at Minimarket
    </div>
</body>
</html>


