<!-- resources/views/products/create.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Create Product') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <form action="{{ route('products.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="product_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Product Name:</label>
                        <input type="text" name="product_name" id="product_name" class="mt-1 p-2 border rounded-md w-full dark:bg-gray-700 dark:text-gray-300" placeholder="Enter product name" required autofocus>
                    </div>
                    <div class="mb-4">
                        <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Category:</label>
                        <select name="category_id" id="category_id" class="mt-1 p-2 border rounded-md w-full dark:bg-gray-700 dark:text-gray-300" placeholder="Select category" required>
                            <option value="" disabled selected>Select Category</option>
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Price:</label>
                        <input type="number" name="price" id="price" class="mt-1 p-2 border rounded-md w-full dark:bg-gray-700 dark:text-gray-300" placeholder="Enter price" required>
                    </div>
                    <div class="mb-4">
                        <label for="product_stock" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Stock:</label>
                        <input type="number" name="product_stock" id="product_stock" class="mt-1 p-2 border rounded-md w-full dark:bg-gray-700 dark:text-gray-300" placeholder="Enter stock" required>
                    </div>
                    <div class="mb-4">
                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status:</label>
                        <select name="status" id="status" class="mt-1 p-2 border rounded-md w-full dark:bg-gray-700 dark:text-gray-300" placeholder="Select status" required>
                            <option value="available">Available</option>
                            <option value="not_available">Not Available</option>
                        </select>
                    </div>
                    <div>
                        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">Create Product</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

