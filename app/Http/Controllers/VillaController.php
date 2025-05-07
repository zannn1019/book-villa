<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Villa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class VillaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');

        $villas = Villa::query()
            ->when(
                $search,
                fn($query) =>
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%")
            )
            ->limit(10)
            ->get();

        return Inertia::render('Welcome', [
            'villas' => $villas,
            'filters' => [
                'search' => $search,
            ]
        ]);
    }

    public function adminList()
    {
        return Inertia::render("Villa/index", [
            'villas' => Villa::paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Villa/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price_per_night' => 'required|numeric',
            'location' => 'required',
            'capacity' => 'required|integer',
            'image' => 'nullable',
        ]);

        Villa::create($data);

        return redirect()->route('villa.admin')->with('success', 'Villa added!');
    }

    public function search(Request $request)
    {
        $query = Villa::query();

        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        $villas = $query->paginate(6);

        return view('villas.search', compact('villas'));
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $villa = Villa::findOrFail($id);

        return Inertia::render('Villa/Detail', [
            'villa' => $villa
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $villa = Villa::findOrFail($id);

        return Inertia::render('Villa/Edit', [
            'villa' => $villa
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $villa = Villa::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'price_per_night' => 'required|numeric',
            'location' => 'required|string',
            'capacity' => 'required|integer',
        ]);

        $villa->update($validated);

        return redirect()->route('villa.admin')->with('success', 'Villa updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $villa = Villa::findOrFail($id);
        $villa->delete();

        return redirect()->route('villa.admin')->with('success', 'Villa deleted!');
    }
}
