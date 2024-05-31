<!-- resources/views/transactions/create.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Create Transaction') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <form action="{{ route('transactions.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="transaction_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Transaction Date:</label>
                            <input type="date" name="transaction_date" id="transaction_date" class="mt-1 p-2 border rounded-md w-full dark:bg-gray-700 dark:text-gray-300" required value="<?php echo date('Y-m-d') ?>">
                        </div>
                        <div>
                            <label for="customer" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Customer:</label>
                            <input type="text" name="customer" id="customer" class="mt-1 p-2 border rounded-md w-full dark:bg-gray-700 dark:text-gray-300">
                        </div>
                    </div>
                    <div id="products">
                        <div class="mb-4" id="product-row-0">
                            <label for="product_0" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Product:</label>
                            <select name="products[0][id]" id="product_0" class="mt-1 p-2 border rounded-md w-full dark:bg-gray-700 dark:text-gray-300" required>
                                <option value="" disabled selected>Select Product</option>
                                @foreach ($products as $product)
                                <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                                @endforeach
                            </select>
                            <label for="quantity_0" class="block mt-2 text-sm font-medium text-gray-700 dark:text-gray-300">Quantity:</label>
                            <input type="number" name="products[0][quantity]" id="quantity_0" class="mt-1 p-2 border rounded-md w-full dark:bg-gray-700 dark:text-gray-300" required>
                        </div>
                    </div>
                    <button type="button" id="add-product" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">Add Product</button>
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">Create Transaction</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let productId = 1;
        const addProductButton = document.getElementById('add-product');
        const productsContainer = document.getElementById('products');

        addProductButton.addEventListener('click', function() {
            const productRow = document.createElement('div');
            productRow.classList.add('mb-4');
            productRow.id = `product-row-${productId}`;

            const productLabel = document.createElement('label');
            productLabel.htmlFor = `product_${productId}`;
            productLabel.classList.add('block', 'text-sm', 'font-medium', 'text-gray-700', 'dark:text-gray-300');
            productLabel.textContent = 'Product:';
            productRow.appendChild(productLabel);

            const productSelect = document.createElement('select');
            productSelect.name = `products[${productId}][id]`;
            productSelect.id = `product_${productId}`;
            productSelect.classList.add('mt-1', 'p-2', 'border', 'rounded-md', 'w-full', 'dark:bg-gray-700', 'dark:text-gray-300');
            productSelect.required = true;
            productSelect.innerHTML = document.getElementById('product_0').innerHTML;
            productRow.appendChild(productSelect);

            const quantityLabel = document.createElement('label');
            quantityLabel.htmlFor = `quantity_${productId}`;
            quantityLabel.classList.add('block', 'mt-2', 'text-sm', 'font-medium', 'text-gray-700', 'dark:text-gray-300');
            quantityLabel.textContent = 'Quantity:';
            productRow.appendChild(quantityLabel);

            const quantityInput = document.createElement('input');
            quantityInput.type = 'number';
            quantityInput.name = `products[${productId}][quantity]`;
            quantityInput.id = `quantity_${productId}`;
            quantityInput.classList.add('mt-1', 'p-2', 'border', 'rounded-md', 'w-full', 'dark:bg-gray-700', 'dark:text-gray-300');
            quantityInput.required = true;
            productRow.appendChild(quantityInput);

            productsContainer.appendChild(productRow);

            productId++;
        });
    });
</script>

