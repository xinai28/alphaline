<?php

namespace App\Http\Controllers;

class GraphController extends Controller
{
    public function index()
    {
        // CSV path
        $path = storage_path('app/data/sample_data.csv');
        $data = [];

        if (!file_exists($path)) {
            abort(404, 'CSV file not found. Please put it in storage/app/data/sample_data.csv');
        }

        // Read CSV
        if (($handle = fopen($path, 'r')) !== false) {
            $header = fgetcsv($handle); // assume first row is header
            while (($row = fgetcsv($handle)) !== false) {
                $data[] = array_combine($header, $row);
            }
            fclose($handle);
        }

        if (empty($data)) {
            abort(500, 'CSV is empty or invalid.');
        }

        // Extract equity values as floats
        $equity = array_map(fn($row) => (float)$row['equity'], $data);

        // Calculate daily PnL (profit/loss)
        $pnl = [];
        for ($i = 1; $i < count($equity); $i++) {
            $pnl[] = $equity[$i] - $equity[$i - 1];
        }

        // 4a. Annual Return = mean of PnL × 365
        $meanPnl = array_sum($pnl) / count($pnl);
        $annualReturn = $meanPnl * 365;

        // 4b. Sharpe Ratio = (mean of PnL / std dev of PnL) × sqrt(365)
        $variance = array_sum(array_map(fn($x) => pow($x - $meanPnl, 2), $pnl)) / (count($pnl) - 1);
        $stdDev = sqrt($variance);
        $sharpeRatio = $stdDev != 0 ? ($meanPnl / $stdDev) * sqrt(365) : 0;

        // 4c. Maximum Drawdown = max of DD
        $peak = $equity[0];
        $drawdowns = [];
        foreach ($equity as $value) {
            if ($value > $peak) $peak = $value;
            $drawdowns[] = ($peak - $value) / $peak;
        }
        $maxDrawdown = max($drawdowns);

        // 4d. Calmar Ratio = Annual Return / |Maximum Drawdown|
        $calmarRatio = $maxDrawdown != 0 ? $annualReturn / abs($maxDrawdown) : 0;

        // Pass data to the view
        return view('graph.index', [
            'equity' => $equity,
            'returns' => $pnl,
            'sharpeRatio' => round($sharpeRatio, 4),
            'calmarRatio' => round($calmarRatio, 4),
            'maxDrawdown' => round($maxDrawdown, 4),
            'annualReturn' => round($annualReturn, 4),
        ]);
    }
}
