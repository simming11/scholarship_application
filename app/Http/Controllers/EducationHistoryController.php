<?php

namespace App\Http\Controllers;

use App\Models\EducationHistory;
use Illuminate\Http\Request;

class EducationHistoryController extends Controller
{
    // Display a listing of education histories
    public function index()
    {
        $histories = EducationHistory::all();
        return response()->json($histories);
    }

    // Store a newly created education history in the database
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'ApplicationID' => 'required|string|max:255',
            'EducationLevel' => 'required|string|max:255',
            'AcademicYear' => 'required|string|max:255',
            'GPA' => 'required|numeric',
            'AdvisorName' => 'required|string|max:255',
            'CourseName' => 'required|string|max:255',
        ]);

        $history = EducationHistory::create($validatedData);

        return response()->json($history, 201); // 201 Created
    }

    // Display the specified education history
    public function show($id)
    {
        $history = EducationHistory::findOrFail($id);
        return response()->json($history);
    }

    // Update the specified education history in the database
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'ApplicationID' => 'sometimes|required|string|max:255',
            'EducationLevel' => 'sometimes|required|string|max:255',
            'AcademicYear' => 'sometimes|required|string|max:255',
            'GPA' => 'sometimes|required|numeric',
            'AdvisorName' => 'sometimes|required|string|max:255',
            'CourseName' => 'sometimes|required|string|max:255',
        ]);

        $history = EducationHistory::findOrFail($id);
        $history->update($validatedData);

        return response()->json($history);
    }

    // Remove the specified education history from the database
    public function destroy($id)
    {
        $history = EducationHistory::findOrFail($id);
        $history->delete();

        return response()->json(null, 204); // 204 No Content
    }
}
