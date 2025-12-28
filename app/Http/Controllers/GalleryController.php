<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::all();
        return view('admin.gallery.index', compact('galleries'));
    }

    public function create()
    {
        return view('admin.gallery.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $imageName = time().'.'.$request->gambar->extension();  
        $request->gambar->move(public_path('uploads/gallery'), $imageName);

        Gallery::create([
            'judul' => $request->judul,
            'gambar' => $imageName
        ]);
        
        return redirect()->route('admin.gallery.index')
            ->with('success', 'Foto berhasil ditambahkan');
    }

    public function destroy($id)
    {
        $gallery = Gallery::findOrFail($id);
        
        // Hapus gambar
        if (file_exists(public_path('uploads/gallery/'.$gallery->gambar))) {
            unlink(public_path('uploads/gallery/'.$gallery->gambar));
        }
        
        $gallery->delete();
        
        return redirect()->route('admin.gallery.index')
            ->with('success', 'Foto berhasil dihapus');
    }
}
