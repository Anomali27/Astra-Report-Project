<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Department;
use App\Models\Task;
use App\Models\TaskActivityLog;
use App\Models\TaskSubmission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Astra Report - Daftar Task';
        $tasks = Task::with(['department', 'area', 'creator'])
            ->withCount('submissions')
            ->get();

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
            'department_id' => ['required', 'exists:departments,id'],
            'area_id' => ['required', 'exists:areas,id'],
            'due_at' => ['required', 'date']
        ]);

        $validatedData['created_by'] = Auth::id();

        Task::create($validatedData);
        return redirect()->route('tasks.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        $title = "Astra Report - Detail task";
        $task->load(['department', 'area', 'creator']);

        return view('tasks.show', [
            'title' => $title,
            'task' => $task
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        abort_if(
            $task->submissions()->exists(),
            403,
            'Tugas tidak dapat diedit karena sudah dikumpulkan.'
        );

        $title = "Astra Report - Edit task";
        $departments = Department::all();
        $areas = Area::all();


        return view('tasks.edit', [
            'title' => $title,
            'task' => $task,
            'departments' => $departments,
            'areas' => $areas
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        abort_if(
            $task->submissions()->exists(),
            403,
            'Tugas tidak dapat diedit karena sudah dikumpulkan.'
        );

        $validatedData = request()->validate([
            'title' => ['required', 'string', 'max:255'],
            'department_id' => ['required', 'exists:departments,id'],
            'area_id' => ['required', 'exists:areas,id'],
            'due_at' => ['required', 'date']
        ]);

        $task->update($validatedData);
        return redirect()->route('tasks.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        abort_if(
            $task->submissions()->exists(),
            403,
            'Tugas tidak dapat dihapus karena sudah dikumpulkan.'
        );

        $task->delete();
        return redirect()->route('tasks.index');
    }

    public function review(Task $task)
    {
        $title = "Astra Report - Review Task";
        $task->load(['department', 'area']);

        $submissions = $task->submissions()
            ->with(['dealer', 'logs.user'])
            ->latest('submitted_at')
            ->get();

        return view('tasks.review', [
            'title' => $title,
            'task' => $task,
            'submissions' => $submissions
        ]);
    }

    public function submit(Task $task)
    {
        $title = 'Astra Report - Pengumpulan Task';

        $submission = TaskSubmission::where('task_id', $task->id)
            ->where('dealer_id', Auth::id())
            ->with('logs.user')
            ->first();

        return view('tasks.submit', [
            'title' => $title,
            'task' => $task,
            'submission' => $submission,
        ]);
    }

    public function storeSubmission(Request $request, Task $task)
    {
        // Periksa deadline
        if (now()->startOfDay()->gt($task->due_at)) {
            return back()->withErrors([
                'google_drive_url' => 'Batas waktu pengumpulan sudah lewat.',
            ]);
        }

        // Validasi input
        $validatedData = $request->validate([
            'google_drive_url' => ['required', 'url', 'max:2048'],
            'note' => ['nullable', 'string', 'max:2000'],
        ]);

        // Cari pengumpulan milik dealer ini
        $submission = TaskSubmission::where('task_id', $task->id)
            ->where('dealer_id', Auth::id())
            ->first();

        // Pengumpulan ulang hanya boleh jika status REVISI
        if ($submission && $submission->status !== 'REVISI') {
            return back()->withErrors([
                'google_drive_url' => 'Pengumpulan ulang hanya diperbolehkan jika status REVISI.',
            ]);
        }

        $submission = TaskSubmission::updateOrCreate(
            [
                'task_id' => $task->id,
                'dealer_id' => Auth::id(),
            ],
            [
                'google_drive_url' => $validatedData['google_drive_url'],
                'status' => 'MENUNGGU_PEMERIKSAAN',
                'submitted_at' => now(),
                'reviewed_by' => null,
                'reviewed_at' => null,
            ]
        );

        TaskActivityLog::create([
            'task_submission_id' => $submission->id,
            'user_id' => Auth::id(),
            'activity' => 'Pengumpulan task',
            'note' => $validatedData['note'] ?? null,
        ]);

        return redirect()
            ->route('tasks.submit', $task->id)
            ->with('success', 'Task berhasil dikumpulkan.');
    }

    public function reviewSubmission(
        Request $request,
        Task $task,
        TaskSubmission $submission
    ) {
        if ($submission->task_id !== $task->id) {
            abort(404);
        }

        $validatedData = $request->validate([
            'status' => ['required', 'in:DISETUJUI,REVISI,DITOLAK'],
            'note' => ['nullable', 'string'],
        ]);

        if (in_array($submission->status, ['DISETUJUI', 'DITOLAK'], true)) {
            return back()->withErrors([
                'status' => 'Pengumpulan sudah memiliki status final.',
            ]);
        }

        $submission->update([
            'status' => $validatedData['status'],
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
        ]);

        TaskActivityLog::create([
            'task_submission_id' => $submission->id,
            'user_id' => Auth::id(),
            'activity' => 'Review: ' . $validatedData['status'],
            'note' => $validatedData['note'] ?? null,
        ]);

        return redirect()->route('tasks.review', $task->id)
            ->with('success', 'Review berhasil disimpan.');
    }


}
