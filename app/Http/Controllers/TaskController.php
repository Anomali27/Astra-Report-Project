<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Department;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "Astra Report - Daftar Task";
        $tasks = Task::all();
        
        return view('tasks.index', [
            'title' => $title,
            'tasks' => $tasks
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Astra Report - Tambah task";
        $departments = Department::all();
        $areas = Area::all();

        return view('tasks.create', [
            'title' => $title,
            'departments' => $departments,
            'areas' => $areas
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'department_id' => ['required', ]
        ]);

        Task::create($validatedData);
        return redirect()->route('tasks.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $title = "Astra Report - Detail task";
        $task = Task::findOrFail($id);

        return view('tasks.show', [
            'title' => $title,
            'task' => $task
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $title = "Astra Report - Edit task";
        $task = Task::findOrFail($id);

        return view('tasks.edit', [
            'title' => $title,
            'task' => $task
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $area)
    {
        $validatedData = request()->validate([
            'code' => ['required', 'string','size:2', 'max:2', 'unique:tasks,code,' . $area->id],
            'name' => ['required', 'exists:department,id'],
            'area_id' => ['required', 'exists:area,id'],
            'due_at' => ['required', 'date']
        ]);

        $area->update($validatedData);
        return redirect()->route('tasks.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index');
    }
}
