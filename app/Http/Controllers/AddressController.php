<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    // Display a listing of the addresses
    public function index()
    {
        $addresses = Address::all();
        return response()->json($addresses);
    }

    // Store a newly created address in the database
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'ApplicationID' => 'required|string|max:255',
            'AddressLine' => 'required|string|max:255',
            'Subdistrict' => 'required|string|max:255',
            'District' => 'required|string|max:255',
            'PostalCode' => 'required|string|max:10',
            'Type' => 'required|string|max:255',
        ]);

        $address = Address::create($validatedData);

        return response()->json($address, 201); // 201 Created
    }

    // Display the specified address
    public function show($id)
    {
        $address = Address::findOrFail($id);
        return response()->json($address);
    }

    // Update the specified address in the database
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'ApplicationID' => 'sometimes|required|string|max:255',
            'AddressLine' => 'sometimes|required|string|max:255',
            'Subdistrict' => 'sometimes|required|string|max:255',
            'District' => 'sometimes|required|string|max:255',
            'PostalCode' => 'sometimes|required|string|max:10',
            'Type' => 'sometimes|required|string|max:255',
        ]);

        $address = Address::findOrFail($id);
        $address->update($validatedData);

        return response()->json($address);
    }

    // Remove the specified address from the database
    public function destroy($id)
    {
        $address = Address::findOrFail($id);
        $address->delete();

        return response()->json(null, 204); // 204 No Content
    }
}
