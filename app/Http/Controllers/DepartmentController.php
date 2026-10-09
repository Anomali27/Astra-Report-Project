<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "Astra Report - Daftar Department";
        $departments = Department::all();

        return view('departments.index', [
            'title' => $title,
            'departments' => $departments
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Astra Report - Tambah Department";

        return view('departments.create', [
            'title' => $title
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'code' => ['string', 'required','size:3', 'max:3', 'unique:departments,code'],
            'name' => ['string', 'required']
        ]);

        Department::create($validatedData);
        return redirect()->route('departments.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $title = "Astra Report - Detail Department";
        $department = Department::findOrFail($id);

        return view('departments.show', [
            'title' => $title,
            'department' => $department
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $title = "Astra Report - Edit Department";
        $department = Department::findOrFail($id);

        return view('departments.edit', [
            'title' => $title,
            'deparment' => $department
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Department $department)
    {
        $validatedData = request()->validate([
            'code' => ['string', 'required', 'size:3', 'max:3', 'unique:departments,code,' . $department->id],
            'name' => ['string', 'required']
        ]);
        
        $department->update($validatedData);
        return redirect()->route('departments.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        $department->delete();
        return redirect()->route('departments.index');
    }
}
