<!-- resources/views/categories/show.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Category Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name:</label>
                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-200">{{ $category->name }}</p>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description:</label>
                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-200">{{ $category->description }}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
