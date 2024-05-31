<!-- resources/views/products/edit.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Edit Product') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <form action="{{ route('products.update', $product->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label for="product_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Product Name:</label>
                        <input type="text" name="product_name" id="product_name" class="mt-1 p-2 border rounded-md w-full dark:bg-gray-700 dark:text-gray-300" value="{{ $product->product_name }}" required autofocus>
                    </div>
                    <div class="mb-4">
                        <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Category:</label>
                        <select name="category_id" id="category_id" class="mt-1 p-2 border rounded-md w-full dark:bg-gray-700 dark:text-gray-300" required>
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @if ($category->id === $product->category_id) selected @endif>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Price:</label>
                        <input type="number" name="price" id="price" class="mt-1 p-2 border rounded-md w-full dark:bg-gray-700 dark:text-gray-300" value="{{ $product->price }}" required>
                    </div>
                    <div class="mb-4">
                        <label for="product_stock" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Stock:</label>
                        <input type="number" name="product_stock" id="product_stock" class="mt-1 p-2 border rounded-md w-full dark:bg-gray-700 dark:text-gray-300" value="{{ $product->product_stock }}" required>
                    </div>
                    <div class="mb-4">
                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status:</label>
                        <select name="status" id="status" class="mt-1 p-2 border rounded-md w-full dark:bg-gray-700 dark:text-gray-300" required>
                            <option value="available" @if ($product->status === 'available') selected @endif>Available</option>
                            <option value="not_available" @if ($product->status === 'not_available') selected @endif>Not Available</option>
                        </select>
                    </div>
                    <div class="flex justify-end gap-2">
                        <a href="{{ route('products.index') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400">
                            Cancel
                        </a>
                        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
