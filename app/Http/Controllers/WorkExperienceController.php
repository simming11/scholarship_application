<?php

namespace App\Http\Controllers;

use App\Models\WorkExperience;
use Illuminate\Http\Request;

class WorkExperienceController extends Controller
{
    // Display a listing of work experiences
    public function index()
    {
        $experiences = WorkExperience::all();
        return response()->json($experiences);
    }

    // Store a newly created work experience in the database
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'ApplicationID' => 'required|string|max:255',
            'Name' => 'required|string|max:255',
            'JobType' => 'required|string|max:255',
            'Duration' => 'required|string|max:255',
            'Earnings' => 'required|numeric',
        ]);

        $experience = WorkExperience::create($validatedData);

        return response()->json($experience, 201); // 201 Created
    }

    // Display the specified work experience
    public function show($id)
    {
        $experience = WorkExperience::findOrFail($id);
        return response()->json($experience);
    }

    // Update the specified work experience in the database
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'ApplicationID' => 'sometimes|required|string|max:255',
            'Name' => 'sometimes|required|string|max:255',
            'JobType' => 'sometimes|required|string|max:255',
            'Duration' => 'sometimes|required|string|max:255',
            'Earnings' => 'sometimes|required|numeric',
        ]);

        $experience = WorkExperience::findOrFail($id);
        $experience->update($validatedData);

        return response()->json($experience);
    }

    // Remove the specified work experience from the database
    public function destroy($id)
    {
        $experience = WorkExperience::findOrFail($id);
        $experience->delete();

        return response()->json(null, 204); // 204 No Content
    }
}
