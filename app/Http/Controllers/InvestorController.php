<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Investor;

class InvestorController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $searchType = $request->input('search_type', 'name');

        // Start query
        $query = Investor::query();

        // Apply filter if search is provided
        if (!empty($search)) {
            // Only allow specific columns to prevent SQL injection
            if (in_array($searchType, ['name', 'email', 'contact_number'])) {
                $query->where($searchType, 'like', "%{$search}%");
            }
        }

        // Get filtered results
        $investors = $query->get()->toArray();

        return view('investor.index', compact('investors', 'search', 'searchType'));
    }


    public function create()
    {
        return view('investor.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:investors,email',
            'contact_number' => 'nullable|string|max:20',
        ]);

        $investor = Investor::create($data);

        $response = Http::withToken(config('services.cardinal.token'))
            ->post(config('services.cardinal.base_url') . '/investor', $data);

        if ($response->successful()) {
            $investor->update(['api_id' => $response->json('id')]);
        }

        return redirect()->route('investors.index')
            ->with('success', 'Investor created successfully and pushed to API.');
    }

    public function edit(Investor $investor)
    {
        return view('investor.edit', compact('investor'));
    }

    public function update(Request $request, Investor $investor)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:investors,email,' . $investor->id,
            'contact_number' => 'nullable|string|max:20',
        ]);

        $investor->update($data);

        if ($investor->api_id) {
            Http::withToken(config('services.cardinal.token'))
                ->put(config('services.cardinal.base_url') . '/investor/' . $investor->api_id, $data);
        }

        return redirect()->route('investors.index')
            ->with('success', 'Investor updated successfully.');
    }

    public function showInvestments(Investor $investor)
    {
        $investments = $investor->investments()->with('fund')->get();
        $totalInvested = $investments->sum('capital_amount');

        return view('investor.investments', compact('investor', 'investments', 'totalInvested'));
    }

    public function syncInvestors()
    {
        $response = Http::withToken(config('services.cardinal.token'))
            ->get(config('services.cardinal.base_url') . '/investor');

        $investors = $response->json('data');

        foreach ($investors as $inv) {
            Investor::updateOrCreate(
                ['api_id' => $inv['id']],
                [
                    'name' => $inv['name'],
                    'email' => $inv['email'],
                    'contact_number' => $inv['contact_number'] ?? null,
                ]
            );
        }

        return response()->json([
            'message' => 'Investors fetched and saved successfully',
            'count' => count($investors),
        ]);
    }
}
