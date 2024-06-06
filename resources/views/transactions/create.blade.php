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
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                    <!-- Bagian Kiri: Grid Tile -->
                    <div class="shadow-md rounded-lg">
                        <div class="bg-white dark:bg-gray-800 p-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-200 mb-4">Products</h3>
                            <input type="text" id="search-product" class="mb-4 p-2 border rounded-md w-full dark:bg-gray-700 dark:text-gray-300" placeholder="Search Product...">
                            <div id="product-grid" class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                                @foreach ($products->take(12) as $product)
                                <div class="product-item border p-4 rounded-lg flex flex-col items-center justify-between" data-product-name="{{ strtolower($product->product_name) }}">
                                    <div class="flex items-center justify-center">
                                        <img src="{{ asset('storage/' . $product->picture) }}" alt="{{ $product->product_name }}" class="w-24 h-24 object-cover mb-2">
                                    </div>
                                    <p class="text-gray-700 dark:text-gray-300 text-center">{{ $product->product_name }}</p>
                                    <div class="flex items-center justify-center">
                                        <button class="bg-indigo-600 text-white px-2 py-1 mt-2 rounded-md hover:bg-indigo-700 add-product-btn" data-product-id="{{ $product->id }}" data-product-name="{{ $product->product_name }}" data-product-price="{{ $product->price }}">Add</button>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            {{ $products->links('pagination::tailwind') }}
                        </div>
                    </div>
                    
                    <!-- Bagian Kanan: Daftar Produk yang Ditambahkan -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-200 mb-4">Selected Products</h3>
                        <form action="{{ route('transactions.store') }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label for="transaction_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Transaction Date:</label>
                                <input readonly type="date" name="transaction_date" id="transaction_date" class="mt-1 p-2 border rounded-md w-full dark:bg-gray-700 dark:text-gray-300" required value="<?php echo date('Y-m-d') ?>">
                            </div>
                            <div>
                                <label for="customer" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Customer:</label>
                                <input type="text" name="customer" id="customer" class="mt-1 p-2 border rounded-md w-full dark:bg-gray-700 dark:text-gray-300">
                            </div>
                            <div id="selected-products">
                                <!-- Tempat untuk produk yang dipilih -->
                            </div>
                            <div id="total-price" class="text-lg font-medium text-gray-900 dark:text-gray-200 mt-4">
                                Total Price: <span id="total-price-value">Rp0</span>
                            </div>
                            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">Create Transaction</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const addProductButtons = document.querySelectorAll('.add-product-btn');
        const selectedProductsContainer = document.getElementById('selected-products');
        const totalPriceElement = document.getElementById('total-price-value');
        const searchProductInput = document.getElementById('search-product');
        const productItems = document.querySelectorAll('.product-item');
        let totalPrice = 0;

        searchProductInput.addEventListener('input', function() {
            const searchValue = this.value.toLowerCase();
            productItems.forEach(item => {
                const productName = item.getAttribute('data-product-name');
                if (productName.includes(searchValue)) {
                    item.style.display = 'flex';
                } else {
                    item.style.display = 'none';
                }
            });
        });

        addProductButtons.forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.getAttribute('data-product-id');
                const productName = this.getAttribute('data-product-name');
                const productPrice = this.getAttribute('data-product-price');

                const productRow = document.createElement('div');
                productRow.classList.add('mb-4');
                productRow.innerHTML = `
                    <input type="hidden" name="products[${productId}][id]" value="${productId}">
                    <p class="text-gray-700 dark:text-gray-300">${productName}</p>
                    <label for="quantity_${productId}" class="block mt-2 text-sm font-medium text-gray-700 dark:text-gray-300">Quantity:</label>
                    <input type="number" name="products[${productId}][quantity]" id="quantity_${productId}" class="mt-1 p-2 border rounded-md w-full dark:bg-gray-700 dark:text-gray-300 product-quantity" data-product-price="${productPrice}" required>
                `;
                selectedProductsContainer.appendChild(productRow);

                const quantityInput = productRow.querySelector('.product-quantity');
                quantityInput.addEventListener('input', function() {
                    updateTotalPrice();
                });
            });
        });

        function updateTotalPrice() {
            let total = 0;
            const quantityInputs = document.querySelectorAll('.product-quantity');
            quantityInputs.forEach(input => {
                const productPrice = parseFloat(input.getAttribute('data-product-price'));
                const quantity = parseInt(input.value);
                if (!isNaN(quantity)) {
                    total += productPrice * quantity;
                }
            });
            totalPriceElement.textContent = formatRupiah(total);
        }

        function formatRupiah(angka, prefix = "Rp") {
            var numberString = angka.toString().replace(/[^,\d]/g, ""),
                split = numberString.split(","),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                const separator = sisa ? "." : "";
                rupiah += separator + ribuan.join(".");
            }

            return prefix + (split[1] != undefined ? rupiah + "," + split[1] : rupiah);
        }
    });
</script>
