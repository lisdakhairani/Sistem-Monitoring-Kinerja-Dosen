<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PenelitianUser;
use Illuminate\Support\Facades\Auth;

class PenelitianUserController extends Controller
{
    public function index()
    {
        $penelitian = PenelitianUser::where('user_id', Auth::id())->get();
        return view('kinerja.penelitian-user', compact('penelitian'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul_penelitian' => 'required',
            'jenis_penelitian' => 'required',
            'peran' => 'required',
            'sumber_dana' => 'required',
            'jumlah_dana' => 'required|numeric',
            'tahun_kegiatan' => 'required|digits:4',
            'status' => 'required',
        ]);

        $outputFiles = [];
        $buktiFiles = [];

        if ($request->hasFile('output')) {
            foreach ($request->file('output') as $file) {
                $outputFiles[] = $file->store('penelitian/output', 'public');
            }
        }

        if ($request->hasFile('file_bukti')) {
            foreach ($request->file('file_bukti') as $file) {
                $buktiFiles[] = $file->store('penelitian/bukti', 'public');
            }
        }

        PenelitianUser::create([
            'user_id' => Auth::id(),
            'judul_penelitian' => $request->judul_penelitian,
            'jenis_penelitian' => $request->jenis_penelitian,
            'peran' => $request->peran,
            'sumber_dana' => $request->sumber_dana,
            'jumlah_dana' => $request->jumlah_dana,
            'tahun_kegiatan' => $request->tahun_kegiatan,
            'status' => $request->status,
            'output' => json_encode($outputFiles),
            'file_bukti' => json_encode($buktiFiles),
            'nilai' => null
        ]);

        return back()->with('success', 'Data penelitian berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $penelitian = PenelitianUser::findOrFail($id);

        $outputFiles = json_decode($penelitian->output ?? '[]');
        $buktiFiles = json_decode($penelitian->file_bukti ?? '[]');

        if ($request->hasFile('output')) {
            foreach ($request->file('output') as $file) {
                $outputFiles[] = $file->store('penelitian/output', 'public');
            }
        }

        if ($request->hasFile('file_bukti')) {
            foreach ($request->file('file_bukti') as $file) {
                $buktiFiles[] = $file->store('penelitian/bukti', 'public');
            }
        }

        $penelitian->update([
            'judul_penelitian' => $request->judul_penelitian,
            'jenis_penelitian' => $request->jenis_penelitian,
            'peran' => $request->peran,
            'sumber_dana' => $request->sumber_dana,
            'jumlah_dana' => $request->jumlah_dana,
            'tahun_kegiatan' => $request->tahun_kegiatan,
            'status' => $request->status,
            'output' => json_encode($outputFiles),
            'file_bukti' => json_encode($buktiFiles),
        ]);

        return back()->with('success', 'Data penelitian berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $penelitian = PenelitianUser::findOrFail($id);
        $penelitian->delete();

        return back()->with('success', 'Data penelitian berhasil dihapus.');
    }
}
