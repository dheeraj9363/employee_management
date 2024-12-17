<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all employees from the database
        $employees = Employee::all();
        return view('employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Return the employee creation form
        return view('employees.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the form input
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email',
            'mobile' => 'required|string',
            'country_code' => 'required|string',
            'address' => 'nullable|string',
            'gender' => 'required|string',
            'hobbies' => 'nullable|array',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos', 'public');
        }

        // Create the new employee
        Employee::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'country_code' => $request->country_code,
            'address' => $request->address,
            'gender' => $request->gender,
            'hobbies' => implode(',', $request->hobbies ?? []),
            'photo' => $photoPath ?? null,
        ]);

        return redirect()->route('employees.index')->with('success', 'Employee created successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Retrieve the employee by ID
        $employee = Employee::findOrFail($id);

        // Return the edit form with the employee data
        return view('employees.form', compact('employee'));
    }
   
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate the form input
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email,' . $id,
            'mobile' => 'required|string',
            'country_code' => 'required|string',
            'address' => 'nullable|string',
            'gender' => 'required|string',
            'hobbies' => 'nullable|array',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Retrieve the employee by ID
        $employee = Employee::findOrFail($id);

        // Store the new photo if present, and delete the old photo
        if ($request->hasFile('photo')) {
            // Delete the old photo if it exists
            if ($employee->photo) {
                Storage::delete('public/' . $employee->photo);
            }

            // Store the new photo in the public disk under the 'photos' folder
            $photoPath = $request->file('photo')->store('photos', 'public');
        } else {
            // Keep the old photo if no new photo is uploaded
            $photoPath = $employee->photo;
        }

        // Update the employee data
        $employee->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'country_code' => $request->country_code,
            'address' => $request->address,
            'gender' => $request->gender,
            'hobbies' => implode(',', $request->hobbies ?? []), // Store hobbies as a comma-separated string
            'photo' => $photoPath, // Update the photo path
        ]);

        // Redirect with success message
        return redirect()->route('employees.index')->with('success', 'Employee updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $employee = Employee::findOrFail($id);
        if ($employee->photo) {
            Storage::delete('public/' . $employee->photo);
        }
        $employee->delete();
        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully!');
    }
}
