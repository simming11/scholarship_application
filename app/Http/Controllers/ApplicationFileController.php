<?php

namespace App\Http\Controllers;

use App\Models\ApplicationFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApplicationFileController extends Controller
{
    // Display a listing of the application files
    public function index()
    {
        $files = ApplicationFile::all();
        return response()->json($files);
    }

    // Store a newly created application file in the database
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'ApplicationID' => 'required|string|max:255',
            'DocumentName' => 'required|string|max:255',
            'DocumentType' => 'required|string|max:255',
            'FilePath' => 'required|file|mimes:pdf,doc,docx,jpg,png|max:2048', // Ensure the file is uploaded and validated
        ]);

        // Handle the file upload
        if ($request->hasFile('FilePath')) {
            $file = $request->file('FilePath');
            $originalFileName = $file->getClientOriginalName();
            $filePath = $file->storeAs('uploads', $originalFileName, 'public');
            $validatedData['FilePath'] = $filePath; // Save the file path to the database
        }

        $applicationFile = ApplicationFile::create($validatedData);

        return response()->json($applicationFile, 201); // 201 Created
    }

    // Display the specified application file
    public function show($id)
    {
        $file = ApplicationFile::findOrFail($id);
        return response()->json($file);
    }

    // Update the specified application file in the database
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'ApplicationID' => 'sometimes|required|string|max:255',
            'DocumentName' => 'sometimes|required|string|max:255',
            'DocumentType' => 'sometimes|required|string|max:255',
            'FilePath' => 'sometimes|required|file|mimes:pdf,doc,docx,jpg,png|max:2048', // Ensure the file is uploaded and validated
        ]);

        $file = ApplicationFile::findOrFail($id);

        // Handle the file upload if a new file is provided
        if ($request->hasFile('FilePath')) {
            $newFile = $request->file('FilePath');
            $originalFileName = $newFile->getClientOriginalName();
            $filePath = $newFile->storeAs('uploads', $originalFileName, 'public');
            $validatedData['FilePath'] = $filePath; // Update the file path in the database

            // Optionally, delete the old file
            if ($file->FilePath) {
                Storage::disk('public')->delete($file->FilePath);
            }
        }

        $file->update($validatedData);

        return response()->json($file);
    }

    // Remove the specified application file from the database
    public function destroy($id)
    {
        $file = ApplicationFile::findOrFail($id);

        // Optionally, delete the file from storage
        if ($file->FilePath) {
            Storage::disk('public')->delete($file->FilePath);
        }

        $file->delete();

        return response()->json(null, 204); // 204 No Content
    }
}
