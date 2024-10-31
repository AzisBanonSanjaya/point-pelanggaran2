<?php

namespace App\Http\Controllers\dataMaster;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DataMaster\Kelas;

class KelasController extends Controller
{
    // Menampilkan daftar kelas
    public function index()
    {
        $kelas = Kelas::all(); // Mengambil semua data kelas
        return view('backEnd.dataMaster.kelas.index', compact('kelas')); // Mengarahkan ke view index
    }

    // Menampilkan form untuk menambah kelas baru
    public function create()
    {
        return view('backEnd.dataMaster.kelas.create'); // Mengarahkan ke view create
    }

    // Menyimpan data kelas baru
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama_kelas' => 'required|string|max:255|unique:kelas',
        ]);

        // Menyimpan data kelas ke database
        Kelas::create([
            'nama_kelas' => $request->nama_kelas,
        ]);

        return redirect()->route('indexKelas')->with('success', 'Kelas berhasil ditambahkan!');
    }

    // Menampilkan form edit untuk kelas tertentu berdasarkan ID
    public function edit($id)
    {
        $kelas = Kelas::findOrFail($id); // Mencari kelas berdasarkan ID
        return view('backEnd.dataMaster.kelas.edit', compact('kelas')); // Mengarahkan ke view edit
    }

    // Mengupdate data kelas berdasarkan ID
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'nama_kelas' => 'required|string|max:255|unique:kelas,nama_kelas,' . $id,
        ]);

        // Mengupdate data kelas di database
        $kelas = Kelas::findOrFail($id);
        $kelas->update([
            'nama_kelas' => $request->nama_kelas,
        ]);

        return redirect()->route('indexKelas')->with('success', 'Kelas berhasil diupdate!');
    }

    // Menghapus data kelas berdasarkan ID
    public function destroy($id)
    {
        $kelas = Kelas::findOrFail($id); // Mencari kelas berdasarkan ID
        $kelas->delete(); // Menghapus kelas

        return redirect()->route('indexKelas')->with('success', 'Kelas berhasil dihapus!');
    }
}
