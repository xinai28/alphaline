<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Investor;

class InvestorController extends Controller
{
   public function index()
    {
        $investors = Investor::all(); // fetch all investors from DB
        return view('investor.index', compact('investors'));
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

        //$data['api_id'] = null;

        // Create locally
        $investor = Investor::create($data);

        // Push to external API
        $response = Http::withToken(config('services.cardinal.token'))
            ->post(config('services.cardinal.base_url') . '/investor', $data);

        if ($response->successful()) {
            // Save api_id returned by API
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

        // Update locally
        $investor->update($data);

        // Push updated data to external API
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

        return view('investor.investments', compact(
            'investor',
            'investments',
            'totalInvested'
        ));
    }

    public function syncInvestors()
    {
        $response = Http::withToken(config('services.cardinal.token'))
            ->get(config('services.cardinal.base_url') . '/investor');

        $investors = $response->json()['data'];

        foreach ($investors as $investor) {
            Investor::updateOrCreate(
                ['api_id' => $investor['id']], // match condition
                [
                    'name' => $investor['name'],
                    'email' => $investor['email'],
                    'contact_number' => $investor['contact_number'] ?? null,
                ]
            );
        }

        return response()->json([
            'message' => 'Investors fetched and saved successfully',
            'count' => count($investors),
        ]);
    }
}
