<?php

namespace App\Http\Controllers;

use App\Models\ScholarshipHistory;
use Illuminate\Http\Request;

class ScholarshipHistoryController extends Controller
{
    // Display a listing of scholarship histories
    public function index()
    {
        $histories = ScholarshipHistory::all();
        return response()->json($histories);
    }

    // Store a newly created scholarship history in the database
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'ApplicationID' => 'required|string|max:255',
            'ScholarshipName' => 'required|string|max:255',
            'AmountReceived' => 'required|numeric',
            'AcademicYear' => 'required|string|max:255',
        ]);

        $history = ScholarshipHistory::create($validatedData);

        return response()->json($history, 201); // 201 Created
    }

    // Display the specified scholarship history
    public function show($id)
    {
        $history = ScholarshipHistory::findOrFail($id);
        return response()->json($history);
    }

    // Update the specified scholarship history in the database
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'ApplicationID' => 'sometimes|required|string|max:255',
            'ScholarshipName' => 'sometimes|required|string|max:255',
            'AmountReceived' => 'sometimes|required|numeric',
            'AcademicYear' => 'sometimes|required|string|max:255',
        ]);

        $history = ScholarshipHistory::findOrFail($id);
        $history->update($validatedData);

        return response()->json($history);
    }

    // Remove the specified scholarship history from the database
    public function destroy($id)
    {
        $history = ScholarshipHistory::findOrFail($id);
        $history->delete();

        return response()->json(null, 204); // 204 No Content
    }
}
