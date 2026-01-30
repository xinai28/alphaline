<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Investment;
use App\Models\Investor;
use App\Models\Fund;

class FundController extends Controller
{
    public function index()
    {
        return view('fund.index');
    }

    public function syncFunds()
    {
        $response = Http::withToken(config('services.cardinal.token'))
            ->get(config('services.cardinal.base_url') . '/fund');

        if (!$response->successful()) {
            return response()->json(['error' => 'Failed to fetch funds'], 500);
        }

        $funds = $response->json()['data'];

        foreach ($funds as $fund) {
            Fund::updateOrCreate(
                ['api_id' => $fund['id']],   // match condition
                ['name' => $fund['name']]    // fields to update
            );
        }

        return response()->json([
            'message' => 'Funds fetched and saved successfully',
            'count' => count($funds),
        ]);
    }
}