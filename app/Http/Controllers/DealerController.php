<?php

namespace App\Http\Controllers;

use App\Models\Dealer;
use Illuminate\Http\Request;

class DealerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "Astra Report - Daftar Dealer";
        $dealers = Dealer::all();
        
        return view('dealers.index', [
            'title' => $title,
            'dealers' => $dealers
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Astra Report - Tambah Dealer";
        
        return view('dealers.create', [
            'title' => $title,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'code' => ['required', 'string','size:4', 'unique:dealers,code'],
            'name' => ['required', 'string', 'max:255']
        ]);

        Dealer::create($validatedData);
        return redirect()->route('dealers.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $title = "Astra Report - Detail Dealer";
        $dealer = Dealer::findOrFail($id);
        
        return view('dealers.show', [
            'title' => $title,
            'dealer' => $dealer
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $title = "Astra Report - Edit Dealer";
        
        $dealer = Dealer::findOrFail($id);
        
        return view('dealers.edit', [
            'title' => $title,
            'dealer' => $dealer
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Dealer $dealer)
    {
        $validatedData = $request->validate([
            'code' => ['required', 'string','size:4', 'unique:dealers,code,' . $dealer->id],
            'name' => ['required', 'string']
        ]);

        $dealer->update($validatedData);
        return redirect()->route('dealers.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dealer $dealer)
    {
        $dealer->delete();
        return redirect()->route('dealers.index');
    }
}
