<?php

namespace App\Http\Controllers;

use App\Models\Penelitian;
use App\Models\Pengabdian;
use App\Models\Pengajaran;
use App\Models\Penunjang;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminMonitoringController extends Controller
{
    public function dashboard()
    {
        $menudashboard = 'active';

        $jumlahPenelitian = Penelitian::count();
        $jumlahPengajaran = Pengajaran::count();
        $jumlahPengabdian = Pengabdian::count();
        $jumlahPenunjang  = Penunjang::count();

        return view('dahsboard-admin', compact(
            'menudashboard',
            'jumlahPenelitian',
            'jumlahPengajaran',
            'jumlahPengabdian',
            'jumlahPenunjang'
        ));
    }

    public function adminPenelitian()
    {
        $penelitian = Penelitian::with('users')->paginate(20);
        $adminPenelitian = 'active';
        return view('kinerja.penelitian-admin', compact('adminPenelitian','penelitian'));
    }

    public function nilaiPenelitian(Request $request, $id)
    {
        $request->validate([
            'nilai' => 'required|integer|min:1|max:10',
        ]);

        $penelitian = Penelitian::findOrFail($id);
        $penelitian->nilai = $request->nilai;
        $penelitian->save();

        return redirect()->back()->with('success', 'Penilaian berhasil dinilai.');
    }

    public function updatePenelitian(Request $request, $id)
    {
        $data = $request->validate([
            'judul_penelitian' => 'required',
            'jenis_penelitian' => 'required',
            'peran' => 'required',
            'sumber_dana' => 'required',
            'jumlah_dana' => 'required|numeric',
            'tahun_kegiatan' => 'required|digits:4',
            'status' => 'required',
            'output.*' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'file_bukti.*' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'nilai' => 'required',
        ]);

        $penelitian = Penelitian::findOrFail($id);

        // Simpan file output baru jika ada
        if ($request->hasFile('output')) {
            $outputPaths = [];
            foreach ($request->file('output') as $outputFile) {
                $outputPaths[] = $outputFile->store('penelitian/output', 'public');
            }
            $data['output'] = json_encode($outputPaths);
        }

        // Simpan file bukti baru jika ada
        if ($request->hasFile('file_bukti')) {
            $buktiPaths = [];
            foreach ($request->file('file_bukti') as $buktiFile) {
                $buktiPaths[] = $buktiFile->store('penelitian/bukti', 'public');
            }
            $data['file_bukti'] = json_encode($buktiPaths);
        }

        $penelitian->update($data);

        return redirect()->route('userPenelitian')->with('success', 'Data berhasil diperbarui');
    }


    public function deletePenelitian($id)
    {
        $penelitian = Penelitian::findOrFail($id);
        $penelitian->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }


    public function adminPengabdian()
    {
        $pengabdian = Pengabdian::with('users')->paginate(20);
        $adminPengabdian = 'active';
        return view('kinerja.pengabdian-admin', compact('adminPengabdian','pengabdian'));
    }

    public function nilaiPengabdian(Request $request, $id)
    {
        $request->validate([
            'nilai' => 'required|integer|min:1|max:10',
        ]);

        $pengabdian = Pengabdian::findOrFail($id);
        $pengabdian->nilai = $request->nilai;
        $pengabdian->save();

        return redirect()->back()->with('success', 'Penilaian berhasil dinilai.');
    }

    public function updatePengabdian(Request $request, $id)
    {
        $pengabdian = Pengabdian::findOrFail($id);

        $data = $request->validate([
            'judul_kegiatan' => 'required',
            'jenis_kegiatan' => 'required',
            'peran' => 'required',
            'lokasi' => 'required',
            'tahun_kegiatan' => 'required|digits:4',
            'sumber_dana' => 'required',
            'jumlah_dana' => 'required|numeric',
            'output.*' => 'file|mimes:pdf,doc,docx|max:20048',
            'file_bukti.*' => 'file|mimes:pdf,doc,docx|max:20048',
            'nilai' => 'required',
        ]);

        // Hapus file output lama jika ada file baru
        if ($request->hasFile('output')) {
            // Hapus file lama dari storage
            foreach (json_decode($pengabdian->output ?? '[]') as $oldFile) {
                Storage::disk('public')->delete($oldFile);
            }

            // Simpan file baru
            $outputPaths = [];
            foreach ($request->file('output') as $file) {
                $outputPaths[] = $file->store('pengabdian/output', 'public');
            }
            $data['output'] = json_encode($outputPaths);
        }

        // Hapus file bukti lama jika ada file baru
        if ($request->hasFile('file_bukti')) {
            foreach (json_decode($pengabdian->file_bukti ?? '[]') as $oldFile) {
                Storage::disk('public')->delete($oldFile);
            }

            $buktiPaths = [];
            foreach ($request->file('file_bukti') as $file) {
                $buktiPaths[] = $file->store('pengabdian/bukti', 'public');
            }
            $data['file_bukti'] = json_encode($buktiPaths);
        }

        $pengabdian->update($data);

        return redirect()->back()->with('success', 'Data berhasil diperbarui.');
    }


    public function deletePengabdian($id)
    {
        Pengabdian::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Data berhasil dihapus.');
    }

    public function adminPengajaran()
    {   $pengajaran = Pengajaran::with('users')->paginate(20);
        $adminPengajaran = 'active';
        return view('kinerja.pengajaran-admin', compact('adminPengajaran','pengajaran'));
    }

    public function nilaiPengajaran(Request $request, $id)
    {
        $request->validate([
            'penilaian' => 'required|integer|min:1|max:10',
        ]);

        $pengajaran = Pengajaran::findOrFail($id);
        $pengajaran->penilaian = $request->penilaian;
        $pengajaran->save();

        return redirect()->back()->with('success', 'Penilaian berhasil dinilai.');
    }

    public function updatePengajaran(Request $request, $id)
    {
        $request->validate([
            'nama_mata_kuliah' => 'required',
            'kode_mata_kuliah' => 'required',
            'jumlah_sks' => 'required|integer',
            'semester' => 'required',
            'tahun_ajaran' => 'required',
            'jumlah_pertemuan' => 'required|integer',
            'file_bukti.*' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'nilai' => 'required',
        ]);

        $pengajaran = Pengajaran::findOrFail($id);
        $pengajaran->nama_mata_kuliah = $request->nama_mata_kuliah;
        $pengajaran->kode_mata_kuliah = $request->kode_mata_kuliah;
        $pengajaran->jumlah_sks = $request->jumlah_sks;
        $pengajaran->semester = $request->semester;
        $pengajaran->tahun_ajaran = $request->tahun_ajaran;
        $pengajaran->jumlah_pertemuan = $request->jumlah_pertemuan;
        $pengajaran->nilai= $request->nilai;

        if ($request->hasFile('file_bukti')) {
            $paths = [];
            foreach ($request->file('file_bukti') as $file) {
                $paths[] = $file->store('pengajaran/bukti', 'public');
            }
            $pengajaran->file_bukti = json_encode($paths);
        }

        $pengajaran->save();

        return redirect()->back()->with('success', 'Data pengajaran berhasil diperbarui.');
    }

    public function deletePengajaran($id)
    {
        $pengajaran = Pengajaran::findOrFail($id);

        // Hapus file dari storage jika ada
        if ($pengajaran->file_bukti) {
            $files = json_decode($pengajaran->file_bukti, true);
            foreach ($files as $file) {
                if (Storage::disk('public')->exists($file)) {
                    Storage::disk('public')->delete($file);
                }
            }
        }

        $pengajaran->delete();

        return redirect()->back()->with('success', 'Data pengajaran berhasil dihapus.');
    }

    public function adminPenunjang()
    {
        $penunjang = Penunjang::with('users')->paginate(20);
        $adminPenunjang = 'active';
        return view('kinerja.penunjang-admin', compact('adminPenunjang','penunjang'));
    }

    public function nilaiPenunjang(Request $request, $id)
    {
        $request->validate([
            'nilai' => 'required|integer|min:1|max:10',
        ]);

        $penunjang = Penunjang::findOrFail($id);
        $penunjang->nilai = $request->nilai;
        $penunjang->save();

        return redirect()->back()->with('success', 'Penilaian berhasil dinilai.');
    }

    public function updatePenunjang(Request $request, $id)
    {
        $penunjang = Penunjang::findOrFail($id);

        $data = $request->validate([
            'jenis_kegiatan' => 'required',
            'nama_kegiatan' => 'required',
            'tingkat_kegiatan' => 'required',
            'tanggal_kegiatan' => 'required|date',
            'institusi_penyelenggara' => 'required',
            'file_bukti.*' => 'file|mimes:pdf,doc,docx|max:20480',
            'nilai' => 'required',
        ]);

        if ($request->hasFile('file_bukti')) {
            // Hapus file lama
            foreach (json_decode($penunjang->file_bukti ?? '[]') as $file) {
                Storage::disk('public')->delete($file);
            }

            $paths = [];
            foreach ($request->file('file_bukti') as $file) {
                $paths[] = $file->store('penunjang/file_bukti', 'public');
            }
            $data['file_bukti'] = json_encode($paths);
        }

        $penunjang->update($data);
        return redirect()->back()->with('success', 'Data berhasil diperbarui.');
    }

    public function deletePenunjang($id)
    {
        $penunjang = Penunjang::findOrFail($id);
        foreach (json_decode($penunjang->file_bukti ?? '[]') as $file) {
            Storage::disk('public')->delete($file);
        }
        $penunjang->delete();
        return redirect()->back()->with('success', 'Data berhasil dihapus.');
    }

    public function index()
    {
        $users = User::where('is_admin', 0)->get();
        $menuUsers = 'active';
        return view('users.index_user', compact('menuUsers', 'users'));
    }

}


?>
