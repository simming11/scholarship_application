<?php

namespace App\Http\Controllers;

use App\Models\ApplicationsExternal;
use Illuminate\Http\Request;

class ApplicationsExternalController extends Controller
{
    // Display a listing of the external applications
    public function index()
    {
        $applications = ApplicationsExternal::all();
        return response()->json($applications);
    }

    // Store a newly created external application in the database
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'StudentID' => 'required|string|max:255',
            'ScholarshipID' => 'required|string|max:255',
            'Status' => 'required|string|max:255',
            'ApplicationDate' => 'required|date',
        ]);

        $application = ApplicationsExternal::create($validatedData);

        return response()->json($application, 201); // 201 Created
    }

    // Display the specified external application
    public function show($id)
    {
        $application = ApplicationsExternal::findOrFail($id);
        return response()->json($application);
    }

    // Update the specified external application in the database
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'StudentID' => 'sometimes|required|string|max:255',
            'ScholarshipID' => 'sometimes|required|string|max:255',
            'Status' => 'sometimes|required|string|max:255',
            'ApplicationDate' => 'sometimes|required|date',
        ]);

        $application = ApplicationsExternal::findOrFail($id);
        $application->update($validatedData);

        return response()->json($application);
    }

    // Remove the specified external application from the database
    public function destroy($id)
    {
        $application = ApplicationsExternal::findOrFail($id);
        $application->delete();

        return response()->json(null, 204); // 204 No Content
    }
}
