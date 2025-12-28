<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Pengumuman;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Gallery;
use App\Models\Kontak;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $beritas = Berita::latest()->take(3)->get();
        $pengumumans = Pengumuman::latest()->take(5)->get();
        $gurus = Guru::all();
        $jumlahGuru = Guru::count();
        $jumlahSiswa = Siswa::count();
        $galleries = Gallery::latest()->take(6)->get();
        
        return view('frontend.index', compact(
            'beritas', 
            'pengumumans', 
            'gurus', 
            'jumlahGuru', 
            'jumlahSiswa',
            'galleries'
        ));
    }

    public function profile()
    {
        return view('frontend.profile');
    }

    public function gallery()
    {
        $galleries = Gallery::all();
        return view('frontend.gallery', compact('galleries'));
    }

    public function kontak()
    {
        $kontak = Kontak::first();
        return view('frontend.kontak', compact('kontak'));
    }

    public function saran(Request $request)
    {
        // Logika untuk menyimpan saran/aduan
        return redirect()->back()->with('success', 'Saran/aduann berhasil dikirim!');
    }
}
