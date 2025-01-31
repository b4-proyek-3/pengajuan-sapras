<?php

namespace App\Http\Controllers;

use App\Models\Ormawa;
use Illuminate\Http\Request;

class OrmawaController extends Controller
{
    public function index()
    {
        $ormawas = Ormawa::all();
        return view('ormawa.index', compact('ormawas'));
    }

    public function create()
    {
        return view('ormawa.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_ormawa' => 'required',
        ]);

        Ormawa::create($request->all());
        return redirect()->route('ormawa.index')
            ->with('success', 'Ormawa created successfully.');
    }

    public function show(Ormawa $ormawa)
    {
        return view('ormawa.show', compact('ormawa'));
    }

    public function edit(Ormawa $ormawa)
    {
        return view('ormawa.edit', compact('ormawa'));
    }

    public function update(Request $request, Ormawa $ormawa)
    {
        $request->validate([
            'nama_ormawa' => 'required',
        ]);

        $ormawa->update($request->all());
        return redirect()->route('ormawa.index')
            ->with('success', 'Ormawa updated successfully.');
    }

    public function destroy(Ormawa $ormawa)
    {
        $ormawa->delete();
        return redirect()->route('ormawa.index')
            ->with('success', 'Ormawa deleted successfully.');
    }
}

