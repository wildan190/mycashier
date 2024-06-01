<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 transition-all duration-300 ease-in-out">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Monthly Sales Chart -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-200 mb-4">
                    Monthly Sales
                </h3>
                <canvas id="salesChart"></canvas>
            </div>
            <!-- Products Sold Chart -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-200 mb-4">
                    Products Sold
                </h3>
                <canvas id="productsSoldChart"></canvas>
            </div>
            <!-- Products Stock Chart -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-200 mb-4">
                    Products in Stock
                </h3>
                <canvas id="productsStockChart"></canvas>
            </div>
            <!-- Categories Pie Chart -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-200 mb-4">
                    Categories Distribution
                </h3>
                <canvas id="categoriesPieChart" style="max-width: 400px; max-height: 300px;"></canvas>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Monthly Sales Data
            var ctxSales = document.getElementById('salesChart').getContext('2d');
            var salesData = @json($salesData);

            var salesLabels = salesData.map(function(item) {
                return item.month;
            });

            var salesValues = salesData.map(function(item) {
                return item.total_sales;
            });

            new Chart(ctxSales, {
                type: 'line',
                data: {
                    labels: salesLabels,
                    datasets: [{
                        label: 'Monthly Sales',
                        data: salesValues,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Products Sold Data
            var ctxProductsSold = document.getElementById('productsSoldChart').getContext('2d');
            var productsSoldData = @json($productsSold);

            var productsSoldLabels = productsSoldData.map(function(item) {
                return item.product_name;
            });

            var productsSoldValues = productsSoldData.map(function(item) {
                return item.total_sold;
            });

            new Chart(ctxProductsSold, {
                type: 'bar',
                data: {
                    labels: productsSoldLabels,
                    datasets: [{
                        label: 'Products Sold',
                        data: productsSoldValues,
                        borderColor: 'rgba(255, 99, 132)',
                        backgroundColor: 'rgba(255, 99, 132)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Products Stock Data
            var ctxProductsStock = document.getElementById('productsStockChart').getContext('2d');
            var productsStockData = @json($productsStock);

            var productsStockLabels = productsStockData.map(function(item) {
                return item.product_name;
            });

            var productsStockValues = productsStockData.map(function(item) {
                return item.product_stock;
            });

            new Chart(ctxProductsStock, {
                type: 'bar',
                data: {
                    labels: productsStockLabels,
                    datasets: [{
                        label: 'Products in Stock',
                        data: productsStockValues,
                        borderColor: 'rgba(54, 162, 235, 1)',
                        backgroundColor: 'rgba(54, 162, 235)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Categories Pie Chart
            var ctxCategoriesPie = document.getElementById('categoriesPieChart').getContext('2d');
            var categoriesData = @json($categories);

            var categoriesLabels = categoriesData.map(function(item) {
                return item.name;
            });

            var categoriesValues = categoriesData.map(function(item) {
                return item.products_count;
            });

            new Chart(ctxCategoriesPie, {
                type: 'doughnut',
                data: {
                    labels: categoriesLabels,
                    datasets: [{
                        label: 'Categories Distribution',
                        data: categoriesValues,
                        backgroundColor: [
                            'rgba(255, 99, 132)',
                            'rgba(54, 162, 235)',
                            'rgba(255, 206, 86)',
                            'rgba(75, 192, 192)',
                            'rgba(153, 102, 255)',
                            'rgba(255, 159, 64)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true
                }
            });
        });
    </script>
</x-app-layout>