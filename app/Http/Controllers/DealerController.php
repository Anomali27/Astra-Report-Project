<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DealerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "Astra Report - Daftar Dealer";
        $dealers = [
            [
                'id' => 1,
                'code' => 'DL-0001',
                'name' => 'Dealer Pontianak'
            ],
            [
                'id' => 2,
                'code' => 'DL-0002',
                'name' => 'Dealer Kubu Raya'
            ],
            [
                'id' => 3,
                'code' => 'DL-0003',
                'name' => 'Dealer Palangkaraya'
            ],
            [
                'id' => 4,
                'code' => 'DL-0004',
                'name' => 'Dealer Jakarta'
            ]
        ];
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
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $title = "Astra Report - Detail Dealer";
        
        return view('dealers.show', [
            'title' => $title,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $title = "Astra Report - Edit Dealer";
        
        return view('dealers.edit', [
            'title' => $title,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
