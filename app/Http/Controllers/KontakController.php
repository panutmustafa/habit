<?php

namespace App\Http\Controllers;

use App\Models\Kontak;
use Illuminate\Http\Request;

class KontakController extends Controller
{
    public function index()
    {
        $kontak = Kontak::first();
        return view('admin.kontak.index', compact('kontak'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'alamat' => 'required',
            'email' => 'required|email',
            'telepon' => 'required',
            'maps' => 'nullable|url',
            'website' => 'nullable|url'
        ]);

        $kontak = Kontak::first();
        
        if ($kontak) {
            $kontak->update($request->all());
        } else {
            Kontak::create($request->all());
        }
        
        return redirect()->route('admin.kontak.index')
            ->with('success', 'Informasi kontak berhasil diperbarui');
    }
}
