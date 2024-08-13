<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EmployeeController extends Controller
{
    public function index()
    {
        try {
            $employees = Employee::all();
            return response()->json($employees, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch employees'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:employees',
                'position' => 'required|string|max:255',
                'phone' => 'required|string|max:255',
                'address' => 'required|string|max:255',
                'salary' => 'required|numeric',
            ]);

            $employee = Employee::create($validatedData);
            return response()->json($employee, Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create employee'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    public function show($id)
    {
        try {
            $employee = Employee::findOrFail($id);
            return response()->json($employee, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Employee not found'], Response::HTTP_NOT_FOUND);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $employee = Employee::findOrFail($id);
            $validatedData = $request->validate([
                'name' => 'sometimes|string|max:255',
                'email' => 'sometimes|string|email|max:255|unique:employees,email,'.$employee->id,
                'position' => 'sometimes|string|max:255',
                'phone' => 'sometimes|string|max:255',
                'address' => 'sometimes|string|max:255',
                'salary' => 'sometimes|numeric',
            ]);

            $employee->update($validatedData);
            return response()->json($employee, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update employee'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy($id)
    {
        try {
            $employee = Employee::findOrFail($id);
            $employee->delete();
            return response()->json(null, Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete employee'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
