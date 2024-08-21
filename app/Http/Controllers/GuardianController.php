<?php

namespace App\Http\Controllers;

use App\Models\Guardian;
use Illuminate\Http\Request;

class GuardianController extends Controller
{
    // Display a listing of guardians
    public function index()
    {
        $guardians = Guardian::all();
        return response()->json($guardians);
    }

    // Store a newly created guardian in the database
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'ApplicationID' => 'required|string|max:255',
            'FirstName' => 'required|string|max:255',
            'LastName' => 'required|string|max:255',
            'Type' => 'required|string|max:255',
            'Occupation' => 'required|string|max:255',
            'Income' => 'required|numeric',
            'Age' => 'required|integer',
            'Status' => 'required|string|max:255',
            'Workplace' => 'required|string|max:255',
        ]);

        $guardian = Guardian::create($validatedData);

        return response()->json($guardian, 201); // 201 Created
    }

    // Display the specified guardian
    public function show($id)
    {
        $guardian = Guardian::findOrFail($id);
        return response()->json($guardian);
    }

    // Update the specified guardian in the database
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'ApplicationID' => 'sometimes|required|string|max:255',
            'FirstName' => 'sometimes|required|string|max:255',
            'LastName' => 'sometimes|required|string|max:255',
            'Type' => 'sometimes|required|string|max:255',
            'Occupation' => 'sometimes|required|string|max:255',
            'Income' => 'sometimes|required|numeric',
            'Age' => 'sometimes|required|integer',
            'Status' => 'sometimes|required|string|max:255',
            'Workplace' => 'sometimes|required|string|max:255',
        ]);

        $guardian = Guardian::findOrFail($id);
        $guardian->update($validatedData);

        return response()->json($guardian);
    }

    // Remove the specified guardian from the database
    public function destroy($id)
    {
        $guardian = Guardian::findOrFail($id);
        $guardian->delete();

        return response()->json(null, 204); // 204 No Content
    }
}
