<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class ReportingController extends Controller
{
    public function index()
    {
        $reportings = collect(); // Ambil semua data dari tabel reportings
        return view('backEnd.reporting.index', compact('reportings'));
    }

    public function create()
    {
        return view('backEnd.reporting.create');
    }

    public function store(Request $request)
    {
       $request->validate([
            'tanggal' => 'required|date',
            'siswa_id' => 'required|exists:siswa,id',
            'jenis_pelanggaran' => 'required|string|max:255',
            'poin' => 'required|numeric',
            'keterangan' => 'nullable|string',
        ]);

        Reporting::create([
            'tanggal' => $request->tanggal,
            'siswa_id' => $request->siswa_id,
            'jenis_pelanggaran' => $request->jenis_pelanggaran,
            'poin' => $request->poin,
            'keterangan' => $request->keterangan,
            'created_at' => now(),
            'updated_at' => now(),
        ]);


         return redirect()->route('reporting.index')->with('success', 'Data reporting berhasil ditambahkan.');
    }

    // Menambahkan method show yang dipanggil oleh view
     public function edit($id)
    {
        $reporting = Reporting::findOrFail($id);
        return view('backEnd.reporting.edit', compact('reporting'));
    }

    // Menyimpan perubahan data reporting ke database
    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'siswa_id' => 'required|exists:siswa,id',
            'jenis_pelanggaran' => 'required|string|max:255',
            'poin' => 'required|numeric',
            'keterangan' => 'nullable|string',
        ]);

        $reporting = Reporting::findOrFail($id);
        $reporting->update([
            'tanggal' => $request->tanggal,
            'siswa_id' => $request->siswa_id,
            'jenis_pelanggaran' => $request->jenis_pelanggaran,
            'poin' => $request->poin,
            'keterangan' => $request->keterangan,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('reporting.index')->with('success', 'Data reporting berhasil diupdate.');
    }

}
