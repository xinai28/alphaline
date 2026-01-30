<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Investment;
use App\Models\Investor;
use App\Models\Fund;
use Carbon\Carbon;

class InvestmentController extends Controller
{
   public function index(Request $request)
    {
        $query = Investment::with(['investor', 'fund']);

        // Filtering
        if ($request->filled('investor_id')) {
            $query->where('investor_id', $request->investor_id);
        }

        if ($request->filled('fund_id')) {
            $query->where('fund_id', $request->fund_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('start_date_from')) {
            $query->where('start_date', '>=', $request->start_date_from);
        }

        if ($request->filled('start_date_to')) {
            $query->where('start_date', '<=', $request->start_date_to);
        }

        // Pagination
        $investments = $query->orderBy('start_date', 'desc')->paginate(10)->withQueryString();

        $investors = Investor::all();
        $funds = Fund::all();

        return view('investment.index', compact('investments', 'investors', 'funds'));
    }

   public function syncInvestments()
    {
        $response = Http::withToken(config('services.cardinal.token'))
            ->get(config('services.cardinal.base_url') . '/investments');

        if (!$response->successful()) {
            return response()->json([
                'error' => 'Failed to fetch investments',
                'status' => $response->status(),
                'body' => $response->body(),
            ], 500);
        }

        $investments = $response->json()['data'] ?? [];

        foreach ($investments as $inv) {
            $investor = Investor::where('api_id', $inv['investor']['id'])->first();
            $fund = Fund::where('api_id', $inv['fund']['id'])->first();

            if (!$investor || !$fund) continue;

            $startDate = isset($inv['start_date']) ? Carbon::parse($inv['start_date'])->format('Y-m-d H:i:s') : null;

            Investment::updateOrCreate(
            ['api_id' => $inv['id']],
                [
                    'investor_id' => $investor->id,
                    'fund_id' => $fund->id,
                    'uid' => $inv['uid'] ?? null,
                    'capital_amount' => $inv['capital_amount'] ?? null,
                    'start_date' => $startDate,
                    'status' => $inv['status'] ?? null,
                ]
            );
        }

        return response()->json([
            'message' => 'Investments synced successfully',
            'count' => count($investments),
        ]);
    }
}
