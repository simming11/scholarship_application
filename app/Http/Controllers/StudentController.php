<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    // Display a listing of students
    public function index()
    {
        $students = Student::all();
        return response()->json($students);
    }

    // Store a newly created student in the database
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'StudentID' => 'required|string|max:255|unique:students,StudentID',
            'Password' => 'required|string|min:8',
            'FirstName' => 'required|string|max:255',
            'LastName' => 'required|string|max:255',
            'Email' => 'required|string|email|max:255|unique:students,Email',
            'GPA' => 'required|numeric|between:0,4.0',
            'Year_Entry' => 'required|integer',
            'Religion' => 'required|string|max:255',
            'PrefixName' => 'required|string|max:255',
            'Phone' => 'required|string|max:15',
            'DOB' => 'required|date',
            'Course' => 'required|string|max:255',
        ]);

        // Encrypt the password before saving
        $validatedData['Password'] = bcrypt($validatedData['Password']);

        // Create the student record
        $student = Student::create($validatedData);

        // Create a token for the student
        $token = $student->createToken($request->userAgent(), ['role' => 'student'])->plainTextToken;

        // Log in the student by returning the token and user details
        $response = [
            'user' => $student,
            'token' => $token,
        ];

        return response()->json($response, 201); // 201 Created
    }

    // Display the specified student
    public function show($id)
    {
        $student = Student::findOrFail($id);
        return response()->json($student);
    }

    // Update the specified student in the database
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'Password' => 'sometimes|required|string|min:8',
            'FirstName' => 'sometimes|required|string|max:255',
            'LastName' => 'sometimes|required|string|max:255',
            'Email' => 'sometimes|required|string|email|max:255|unique:students,Email,' . $id . ',StudentID',
            'GPA' => 'sometimes|required|numeric|between:0,4.0',
            'Year_Entry' => 'sometimes|required|integer',
            'Religion' => 'sometimes|required|string|max:255',
            'PrefixName' => 'sometimes|required|string|max:255',
            'Phone' => 'sometimes|required|string|max:15',
            'DOB' => 'sometimes|required|date',
            'Course' => 'sometimes|required|string|max:255',
        ]);

        $student = Student::findOrFail($id);
        $student->update($validatedData);

        return response()->json($student);
    }

    // Remove the specified student from the database
    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();

        return response()->json(null, 204); // 204 No Content
    }
}
