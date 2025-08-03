<?php

namespace App\Http\Controllers;

use App\Models\PengajaranUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PengajaranUserController extends Controller
{
    public function index(Request $request)
    {
        $query = PengajaranUser::where('user_id', Auth::id());

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_mata_kuliah', 'like', "%$search%")
                  ->orWhere('kode_mata_kuliah', 'like', "%$search%")
                  ->orWhere('semester', 'like', "%$search%");
            });
        }

        if ($request->filled('tahun')) {
            $query->where('tahun_ajaran', $request->tahun);
        }

        $pengajaran = $query->orderBy('created_at', 'desc')->get();

        return view('pengguna.pengajaran-user', compact('pengajaran'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_mata_kuliah' => 'required|string|max:255',
            'kode_mata_kuliah' => 'required|string|max:50',
            'jumlah_sks' => 'required|integer',
            'semester' => 'required|string',
            'tahun_ajaran' => 'required|string',
            'jumlah_pertemuan' => 'required|integer',
            'file_bukti.*' => 'file|mimes:pdf,jpg,jpeg,png,doc,docx|max:2048'
        ]);

        $buktiPaths = [];
        if ($request->hasFile('file_bukti')) {
            foreach ($request->file('file_bukti') as $file) {
                $buktiPaths[] = $file->store('pengajaran/bukti', 'public');
            }
        }

        PengajaranUser::create([
            'user_id' => Auth::id(),
            'nama_mata_kuliah' => $request->nama_mata_kuliah,
            'kode_mata_kuliah' => $request->kode_mata_kuliah,
            'jumlah_sks' => $request->jumlah_sks,
            'semester' => $request->semester,
            'tahun_ajaran' => $request->tahun_ajaran,
            'jumlah_pertemuan' => $request->jumlah_pertemuan,
            'file_bukti' => json_encode($buktiPaths),
        ]);

        return redirect()->back()->with('success', 'Data pengajaran berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $pengajaran = PengajaranUser::findOrFail($id);

        if ($pengajaran->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'nama_mata_kuliah' => 'required|string|max:255',
            'kode_mata_kuliah' => 'required|string|max:50',
            'jumlah_sks' => 'required|integer',
            'semester' => 'required|string',
            'tahun_ajaran' => 'required|string',
            'jumlah_pertemuan' => 'required|integer',
            'file_bukti.*' => 'file|mimes:pdf,jpg,jpeg,png,doc,docx|max:2048'
        ]);

        $buktiPaths = json_decode($pengajaran->file_bukti ?? '[]', true);

        if ($request->hasFile('file_bukti')) {
            foreach ($request->file('file_bukti') as $file) {
                $buktiPaths[] = $file->store('pengajaran/bukti', 'public');
            }
        }

        $pengajaran->update([
            'nama_mata_kuliah' => $request->nama_mata_kuliah,
            'kode_mata_kuliah' => $request->kode_mata_kuliah,
            'jumlah_sks' => $request->jumlah_sks,
            'semester' => $request->semester,
            'tahun_ajaran' => $request->tahun_ajaran,
            'jumlah_pertemuan' => $request->jumlah_pertemuan,
            'file_bukti' => json_encode($buktiPaths),
        ]);

        return redirect()->back()->with('success', 'Data pengajaran berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pengajaran = PengajaranUser::findOrFail($id);

        if ($pengajaran->user_id !== Auth::id()) {
            abort(403);
        }

        // Hapus file dari storage
        if ($pengajaran->file_bukti) {
            foreach (json_decode($pengajaran->file_bukti) as $file) {
                Storage::disk('public')->delete($file);
            }
        }

        $pengajaran->delete();

        return redirect()->back()->with('success', 'Data pengajaran berhasil dihapus.');
    }
}
