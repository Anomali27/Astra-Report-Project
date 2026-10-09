<?php

namespace App\Http\Controllers;

use App\Models\Area;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "Astra Report - Daftar Area";
        $areas = Area::all();
        
        return view('areas.index', [
            'title' => $title,
            'areas' => $areas
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Astra Report - Tambah Area";

        return view('areas.create', [
            'title' => $title
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'code' => ['required', 'string','size:2', 'max:2', 'unique:areas,code'],
            'name' => ['required', 'string']
        ]);

        Area::create($validatedData);
        return redirect()->route('areas.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $title = "Astra Report - Detail Area";
        $area = Area::findOrFail($id);

        return view('areas.show', [
            'title' => $title,
            'area' => $area
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $title = "Astra Report - Edit Area";
        $area = Area::findOrFail($id);

        return view('areas.edit', [
            'title' => $title,
            'area' => $area
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Area $area)
    {
        $validatedData = request()->validate([
            'code' => ['required', 'string','size:2', 'max:2', 'unique:areas,code,' . $area->id],
            'name' => ['string', 'required']
        ]);

        $area->update($validatedData);
        return redirect()->route('areas.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Area $area)
    {
        $area->delete();
        return redirect()->route('areas.index');
    }
}
