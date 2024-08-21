<?php

namespace App\Http\Controllers;

use App\Models\Sibling;
use Illuminate\Http\Request;

class SiblingController extends Controller
{
    // Display a listing of siblings
    public function index()
    {
        $siblings = Sibling::all();
        return response()->json($siblings);
    }

    // Store a newly created sibling in the database
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'ApplicationID' => 'required|string|max:255',
            'PrefixName' => 'required|string|max:255',
            'Fname' => 'required|string|max:255',
            'Lname' => 'required|string|max:255',
            'Occupation' => 'required|string|max:255',
            'EducationLevel' => 'required|string|max:255',
            'Income' => 'required|numeric',
            'Status' => 'required|string|max:255',
        ]);

        $sibling = Sibling::create($validatedData);

        return response()->json($sibling, 201); // 201 Created
    }

    // Display the specified sibling
    public function show($id)
    {
        $sibling = Sibling::findOrFail($id);
        return response()->json($sibling);
    }

    // Update the specified sibling in the database
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'ApplicationID' => 'sometimes|required|string|max:255',
            'PrefixName' => 'sometimes|required|string|max:255',
            'Fname' => 'sometimes|required|string|max:255',
            'Lname' => 'sometimes|required|string|max:255',
            'Occupation' => 'sometimes|required|string|max:255',
            'EducationLevel' => 'sometimes|required|string|max:255',
            'Income' => 'sometimes|required|numeric',
            'Status' => 'sometimes|required|string|max:255',
        ]);

        $sibling = Sibling::findOrFail($id);
        $sibling->update($validatedData);

        return response()->json($sibling);
    }

    // Remove the specified sibling from the database
    public function destroy($id)
    {
        $sibling = Sibling::findOrFail($id);
        $sibling->delete();

        return response()->json(null, 204); // 204 No Content
    }
}
