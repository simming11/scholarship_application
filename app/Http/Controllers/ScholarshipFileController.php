<?php

namespace App\Http\Controllers;

use App\Models\ScholarshipFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ScholarshipFileController extends Controller
{
    // Display a listing of scholarship files
    public function index()
    {
        $files = ScholarshipFile::all();
        return response()->json($files);
    }

    // Store a newly created scholarship file in the database
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'ScholarshipID' => 'required|integer|exists:scholarships,ScholarshipID',
            'FileType' => 'required|string|max:255',
            'FilePath' => 'required|file|mimes:pdf,doc,docx,jpg,png|max:2048', // Ensure the file is uploaded and validated
            'Description' => 'nullable|string|max:255',
        ]);

        // Handle the file upload
        if ($request->hasFile('FilePath')) {
            $file = $request->file('FilePath');
            $originalFileName = $file->getClientOriginalName();
            $filePath = $file->storeAs('uploads', $originalFileName, 'public');
            $validatedData['FilePath'] = $filePath; // Save the file path to the database
        }

        $scholarshipFile = ScholarshipFile::create($validatedData);

        return response()->json($scholarshipFile, 201); // 201 Created
    }

    // Display the specified scholarship file
    public function show($id)
    {
        $file = ScholarshipFile::findOrFail($id);
        return response()->json($file);
    }

// Update the specified scholarship files in the database
public function update(Request $request, $id)
{
    $validatedData = $request->validate([
        'ScholarshipID' => 'sometimes|required|integer|exists:scholarships,ScholarshipID',
        'FileType' => 'sometimes|required|array', // Validate that FileType is an array
        'FileType.*' => 'string|max:255', // Each FileType should be a string
        'FilePath' => 'sometimes|required|array', // Validate that FilePath is an array
        'FilePath.*' => 'file|mimes:pdf,doc,docx,jpg,png|max:2048', // Ensure each file is uploaded and validated
        'Description' => 'nullable|array', // Allow descriptions for each file
        'Description.*' => 'string|max:255',
    ]);

    // Retrieve the existing file entries by ScholarshipID
    $files = ScholarshipFile::where('ScholarshipID', $id)->get();

    // Loop through each provided FilePath
    foreach ($validatedData['FilePath'] as $index => $file) {
        $newFile = $file;
        $originalFileName = $newFile->getClientOriginalName();
        $filePath = $newFile->storeAs('uploads', $originalFileName, 'public');
        
        // Prepare data for updating or creating a new file entry
        $fileData = [
            'ScholarshipID' => $validatedData['ScholarshipID'] ?? $id,
            'FileType' => $validatedData['FileType'][$index] ?? '',
            'FilePath' => $filePath,
            'Description' => $validatedData['Description'][$index] ?? null,
        ];

        // Update the file if it exists, otherwise create a new one
        if (isset($files[$index])) {
            // Optionally, delete the old file
            if ($files[$index]->FilePath) {
                Storage::disk('public')->delete($files[$index]->FilePath);
            }
            $files[$index]->update($fileData);
        } else {
            ScholarshipFile::create($fileData);
        }
    }

    return response()->json(['message' => 'Files updated successfully']);
}


    // Remove the specified scholarship file from the database
    public function destroy($id)
    {
        $file = ScholarshipFile::findOrFail($id);

        // Optionally, delete the file from storage
        if ($file->FilePath) {
            Storage::disk('public')->delete($file->FilePath);
        }

        $file->delete();

        return response()->json(null, 204); // 204 No Content
    }

    // Download the specified scholarship file
    public function download($id)
    {
        $file = ScholarshipFile::findOrFail($id);

        if (!$file || !Storage::disk('public')->exists($file->FilePath)) {
            return response()->json(['error' => 'File not found.'], 404);
        }

        $filePath = Storage::disk('public')->path($file->FilePath);
        $fileName = basename($filePath);

        return response()->download($filePath, $fileName);
    }
}
