<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;

class ActivitiesController extends Controller
{
    // Display a listing of the activities
    public function index()
    {
        $activities = Activity::all();
        return response()->json($activities);
    }

    // Store a newly created activity in the database
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'AcademicYear' => 'required|string|max:255',
            'ActivityName' => 'required|string|max:255',
            'Position' => 'required|string|max:255',
            'ApplicationID' => 'required|integer|exists:application_internals,ApplicationID',
        ]);

        $activity = Activity::create($validatedData);

        return response()->json($activity, 201); // 201 Created
    }

    // Display the specified activity
    public function show($id)
    {
        $activity = Activity::findOrFail($id);
        return response()->json($activity);
    }

    // Update the specified activity in the database
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'AcademicYear' => 'sometimes|required|string|max:255',
            'ActivityName' => 'sometimes|required|string|max:255',
            'Position' => 'sometimes|required|string|max:255',
            'ApplicationID' => 'sometimes|required|integer|exists:application_internals,ApplicationID',
        ]);

        $activity = Activity::findOrFail($id);
        $activity->update($validatedData);

        return response()->json($activity);
    }

    // Remove the specified activity from the database
    public function destroy($id)
    {
        $activity = Activity::findOrFail($id);
        $activity->delete();

        return response()->json(null, 204); // 204 No Content
    }
}
