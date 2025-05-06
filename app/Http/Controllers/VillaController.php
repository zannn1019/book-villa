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
    public function index()
    {
        return Inertia::render('Welcome', [
            'villas' => Villa::limit(20)->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('villas');
        }

        Villa::create($data);

        return redirect()->route('villas.index')->with('success', 'Villa added!');
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
