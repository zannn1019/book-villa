<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Villa;
use Illuminate\Http\Request;

class VillaApiController extends Controller
{
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
            ->paginate(10);

        return response()->json($villas);
    }

    public function show($id)
    {
        $villa = Villa::findOrFail($id);
        return response()->json($villa);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'price_per_night' => 'required|numeric',
            'location' => 'required|string',
            'capacity' => 'required|integer',
            'image' => 'nullable|string',
        ]);

        $villa = Villa::create($data);

        return response()->json([
            'message' => 'Villa created successfully',
            'villa' => $villa
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $villa = Villa::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'price_per_night' => 'required|numeric',
            'location' => 'required|string',
            'capacity' => 'required|integer',
            'image' => 'nullable|string',
        ]);

        $villa->update($data);

        return response()->json([
            'message' => 'Villa updated successfully',
            'villa' => $villa
        ]);
    }

    public function destroy($id)
    {
        $villa = Villa::findOrFail($id);
        $villa->delete();

        return response()->json([
            'message' => 'Villa deleted successfully'
        ]);
    }
}
