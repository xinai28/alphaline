<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Equity Graph & Metrics') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6 text-gray-900">

                    <div class="flex justify-between items-center mb-6">
                        <p class="text-lg font-semibold">
                            Equity Curve
                        </p>

                        <x-button onclick="downloadSampleData()">
                            Download Data
                        </x-button>
                    </div>

                    <!-- Chart -->
                    <canvas id="equityChart" class="mb-6" height="200"></canvas>

                    <!-- Metrics -->
                    <div class="grid grid-cols-2 gap-4">
                        <div class="shadow-xl border p-4 rounded-lg">
                            <h1 class="font-bold">Annual Return</h1>
                            <p>{{ $annualReturn * 100 }}%</p>
                        </div>
                        <div class="shadow-xl border p-4 rounded-lg">
                            <h1 class="font-bold">Sharpe Ratio</h1>
                            <p>{{ $sharpeRatio }}</p>
                        </div>
                        <div class="shadow-xl border p-4 rounded-lg">
                            <h1 class="font-bold">Maximum Drawdown</h1>
                            <p>{{ $maxDrawdown * 100 }}%</p>
                        </div>
                        <div class="shadow-xl border p-4 rounded-lg">
                            <h1 class="font-bold">Calmar Ratio</h1>
                            <p>{{ $calmarRatio }}</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Convert PHP equity array to JS
        const equityData = @json($equity);

        const ctx = document.getElementById('equityChart').getContext('2d');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: equityData.map((_, i) => i + 1), // x-axis: index
                datasets: [{
                    label: 'Equity Curve',
                    data: equityData,
                    borderColor: 'blue',
                    backgroundColor: 'rgba(0, 123, 255, 0.1)',
                    fill: true,
                    tension: 0.2
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Time (Days)'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Equity'
                        }
                    }
                }
            }
        });

        function downloadSampleData() {
            window.open('{{ asset("sample_data.csv") }}', "_blank")
        }
    </script>
</x-app-layout>