<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-base text-gray-800 leading-tight">
            {{ __('Equity Graph & Metrics') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-6xl mx-auto sm:px-3 lg:px-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-md">
                <div class="p-2 text-gray-900">

                    <!-- Header + Button -->
                    <div class="flex justify-between items-center mb-3">
                        <p class="text-sm font-semibold">Equity Curve</p>
                        <x-button class="text-xs px-2 py-0.5" onclick="downloadSampleData()">
                            Download Data
                        </x-button>
                    </div>

                    <!-- Chart -->
                    <canvas id="equityChart" class="mb-3" height="120"></canvas>

                    <!-- Metrics -->
                    <div class="grid grid-cols-2 gap-1">
                        <div class="shadow border p-1 rounded-md text-xs">
                            <h1 class="font-semibold">Annual Return</h1>
                            <p>{{ $annualReturn * 100 }}%</p>
                        </div>
                        <div class="shadow border p-1 rounded-md text-xs">
                            <h1 class="font-semibold">Sharpe Ratio</h1>
                            <p>{{ $sharpeRatio }}</p>
                        </div>
                        <div class="shadow border p-1 rounded-md text-xs">
                            <h1 class="font-semibold">Maximum Drawdown</h1>
                            <p>{{ $maxDrawdown * 100 }}%</p>
                        </div>
                        <div class="shadow border p-1 rounded-md text-xs">
                            <h1 class="font-semibold">Calmar Ratio</h1>
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
        const equityData = @json($equity);
        const ctx = document.getElementById('equityChart').getContext('2d');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: equityData.map((_, i) => i + 1),
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
                    legend: { display: true, position: 'top' },
                    tooltip: { mode: 'index', intersect: false }
                },
                scales: {
                    x: { title: { display: true, text: 'Time (Days)' } },
                    y: { title: { display: true, text: 'Equity' } }
                }
            }
        });

        function downloadSampleData() {
            window.open('{{ asset("sample_data.csv") }}', "_blank");
        }
    </script>
</x-app-layout>
