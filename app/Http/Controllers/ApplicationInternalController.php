<?php

namespace App\Http\Controllers;

use App\Models\ApplicationInternal;
use Illuminate\Http\Request;

class ApplicationInternalController extends Controller
{
    // Display a listing of the application internals
    public function index()
    {
        $applications = ApplicationInternal::with([
            'student',
            'scholarship',
            'applicationFiles',
            'addresses',
            'siblings',
            'scholarshipHistories',
            'guardians',
            'activities',
            'educationHistories',
            'workExperiences',
        ])->get();

        return response()->json($applications);
    }

    // Store a newly created application internal in the database
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'StudentID' => 'required|string|max:10|exists:students,StudentID',
            'ScholarshipID' => 'required|integer|exists:scholarships,ScholarshipID',
            'ApplicationDate' => 'required|date',
            'Status' => 'required|string|max:20',
            'MonthlyIncome' => 'nullable|numeric',
            'MonthlyExpenses' => 'nullable|numeric',
            'NumberOfSiblings' => 'nullable|integer',
            'NumberOfSisters' => 'nullable|integer',
            'NumberOfBrothers' => 'nullable|integer',
        ]);

        $application = ApplicationInternal::create($validatedData);

        return response()->json($application, 201); // 201 Created
    }

    // Display the specified application internal
    public function show($id)
    {
        $application = ApplicationInternal::with(['student', 'scholarship'])->findOrFail($id);
        return response()->json($application);
    }

    // Update the specified application internal in the database
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'StudentID' => 'sometimes|required|string|max:10|exists:students,StudentID',
            'ScholarshipID' => 'sometimes|required|integer|exists:scholarships,ScholarshipID',
            'ApplicationDate' => 'sometimes|required|date',
            'Status' => 'sometimes|required|string|max:20',
            'MonthlyIncome' => 'nullable|numeric',
            'MonthlyExpenses' => 'nullable|numeric',
            'NumberOfSiblings' => 'nullable|integer',
            'NumberOfSisters' => 'nullable|integer',
            'NumberOfBrothers' => 'nullable|integer',
        ]);

        $application = ApplicationInternal::findOrFail($id);
        $application->update($validatedData);

        return response()->json($application);
    }

    // Remove the specified application internal from the database
    public function destroy($id)
    {
        $application = ApplicationInternal::findOrFail($id);
        $application->delete();

        return response()->json(null, 204); // 204 No Content
    }
}
