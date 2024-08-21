<?php

namespace App\Http\Controllers;

use App\Models\ScholarshipQualification;
use Illuminate\Http\Request;

class ScholarshipQualificationController extends Controller
{
    // Display a listing of scholarship qualifications
    public function index()
    {
        $qualifications = ScholarshipQualification::all();
        return response()->json($qualifications);
    }

    // Store a newly created scholarship qualification in the database
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'ScholarshipID' => 'required|integer|exists:scholarships,ScholarshipID',
            'qualifications' => 'required|array',
            'qualifications.*' => 'string',
            'otherQualificationText' => 'nullable|str   ing',
        ]);
    
        $qualifications = $validatedData['qualifications'];
    
        // Add the otherQualificationText to the array if it's provided
        if (!empty($validatedData['otherQualificationText'])) {
            $qualifications[] = $validatedData['otherQualificationText'];
        }
    
        foreach ($qualifications as $qualificationText) {
            ScholarshipQualification::create([
                'ScholarshipID' => $validatedData['ScholarshipID'],
                'QualificationText' => $qualificationText,
                'IsActive' => true, // or whatever default value you want
            ]);
        }
    
        return response()->json(['message' => 'Qualifications saved successfully!'], 201);
    }
    
    

    // Display the specified scholarship qualification
    public function show($id)
    {
        $qualification = ScholarshipQualification::findOrFail($id);
        return response()->json($qualification);
    }

    // Update the specified scholarship qualification in the database
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'ScholarshipID' => 'sometimes|required|integer|exists:scholarships,ScholarshipID',
            'qualifications' => 'sometimes|required|array',
            'qualifications.*' => 'string',
            'otherQualificationText' => 'nullable|string',
            'IsActive' => 'sometimes|required|boolean',
        ]);
    
        // Find the qualification entry to update
        $qualification = ScholarshipQualification::findOrFail($id);
    
        // If qualifications array is provided, update them
        if (isset($validatedData['qualifications'])) {
            // Delete old qualifications related to this ScholarshipID
            ScholarshipQualification::where('ScholarshipID', $qualification->ScholarshipID)->delete();
    
            $qualifications = $validatedData['qualifications'];
    
            // Add the otherQualificationText to the array if it's provided
            if (!empty($validatedData['otherQualificationText'])) {
                $qualifications[] = $validatedData['otherQualificationText'];
            }
    
            // Create new qualifications
            foreach ($qualifications as $qualificationText) {
                ScholarshipQualification::create([
                    'ScholarshipID' => $validatedData['ScholarshipID'] ?? $qualification->ScholarshipID,
                    'QualificationText' => $qualificationText,
                    'IsActive' => $validatedData['IsActive'] ?? true, // Use IsActive from request or default to true
                ]);
            }
    
            return response()->json(['message' => 'Qualifications updated successfully!']);
        } else {
            // If only individual fields like IsActive or QualificationText are being updated
            $qualification->update($validatedData);
            return response()->json($qualification);
        }
    }
    

    // Remove the specified scholarship qualification from the database
    public function destroy($id)
    {
        $qualification = ScholarshipQualification::findOrFail($id);
        $qualification->delete();

        return response()->json(null, 204); // 204 No Content
    }
}
