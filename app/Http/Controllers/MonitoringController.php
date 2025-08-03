<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Penelitian;
use App\Models\Pengabdian;
use App\Models\Pengajaran;
use App\Models\Penunjang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class MonitoringController extends Controller
{
    public function index()
    {
        $Bannerawal = 'active';
        return view('auth.bagianawal', compact('Bannerawal'));
    }

     public function dashboard()
    {
        $menudashboard = 'active';
        $userId = Auth::id();

        $jumlahPenelitian = Penelitian::where('user_id', $userId)->count();
        $jumlahPengajaran = Pengajaran::where('user_id', $userId)->count();
        $jumlahPengabdian = Pengabdian::where('user_id', $userId)->count();
        $jumlahPenunjang = Penunjang::where('user_id', $userId)->count();


        return view('dashboard-user', compact('menudashboard',
        'jumlahPenelitian',
        'jumlahPengajaran',
        'jumlahPengabdian',
        'jumlahPenunjang'));
    }


    public function PenelitianUser()
    {
        $userId = Auth::id(); // ambil ID user yang sedang login

        // hanya ambil data usulan milik user yang login
        $penelitian = Penelitian::with('users')
            ->where('user_id', $userId)
            ->paginate(20);

        $PenelitianUser = 'active';
        return view('kinerja.penelitian-user', compact('Penelitian.index', 'penelitian'));
    }

    public function storePenelitian(Request $request)
    {
        $data = $request->validate([
            'judul_penelitian' => 'required',
            'jenis_penelitian' => 'required',
            'peran' => 'required',
            'sumber_dana' => 'required',
            'jumlah_dana' => 'required|numeric',
            'tahun_kegiatan' => 'required|digits:4',
            'status' => 'required',
            'output.*' => 'file|mimes:pdf,doc,docx|max:20048',
            'file_bukti.*' => 'file|mimes:pdf,doc,docx|max:20048',
        ]);

        $data['user_id'] = auth()->id();

        // Simpan file output
        if ($request->hasFile('output')) {
            $outputPaths = [];
            foreach ($request->file('output') as $outputFile) {
                $outputPaths[] = $outputFile->store('penelitian/output', 'public');
            }
            $data['output'] = json_encode($outputPaths); // Simpan sebagai JSON
        }

        // Simpan file bukti
        if ($request->hasFile('file_bukti')) {
            $buktiPaths = [];
            foreach ($request->file('file_bukti') as $buktiFile) {
                $buktiPaths[] = $buktiFile->store('penelitian/bukti', 'public');
            }
            $data['file_bukti'] = json_encode($buktiPaths); // Simpan sebagai JSON
        }

        Penelitian::create($data);

        return redirect()->route('Penelitian.index')->with('success', 'Data berhasil ditambahkan');
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

        return redirect()->route('Penelitian.index')->with('success', 'Data berhasil diperbarui');
    }


    public function deletePenelitian($id)
    {
        $penelitian = Penelitian::findOrFail($id);
        $penelitian->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }

    public function userPengabdian()
    {
        $userId = Auth::id(); // ambil ID user yang sedang login

        // hanya ambil data usulan milik user yang login
        $pengabdian = Pengabdian::with('users')
            ->where('user_id', $userId)
            ->paginate(20);
        $userPengabdian = 'active';
        return view('kinerja.pengabdian-user', compact('userPengabdian','pengabdian'));
    }

    public function storePengabdian(Request $request)
    {
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
        ]);

        $data['user_id'] = Auth::id();

        if ($request->hasFile('output')) {
            $outputPaths = [];
            foreach ($request->file('output') as $file) {
                $outputPaths[] = $file->store('pengabdian/output', 'public');
            }
            $data['output'] = json_encode($outputPaths);
        }

        if ($request->hasFile('file_bukti')) {
            $buktiPaths = [];
            foreach ($request->file('file_bukti') as $file) {
                $buktiPaths[] = $file->store('pengabdian/bukti', 'public');
            }
            $data['file_bukti'] = json_encode($buktiPaths);
        }

        Pengabdian::create($data);

        return redirect()->back()->with('success', 'Data berhasil ditambahkan.');
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

    public function userPengajaran()
    {
        $userId = Auth::id(); // ambil ID user yang sedang login

        // hanya ambil data usulan milik user yang login
        $pengajaran = Pengajaran::with('users')
            ->where('user_id', $userId)
            ->paginate(20);
        $userPengajaran = 'active';
        return view('kinerja.pengajaran-user', compact('userPengajaran', 'pengajaran'));
    }

    public function storePengajaran(Request $request)
    {
        $request->validate([
            'nama_mata_kuliah' => 'required',
            'kode_mata_kuliah' => 'required',
            'jumlah_sks' => 'required|integer',
            'semester' => 'required',
            'tahun_ajaran' => 'required',
            'jumlah_pertemuan' => 'required|integer',
            'file_bukti.*' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $pengajaran = new Pengajaran();
        $pengajaran->user_id = auth()->id();
        $pengajaran->nama_mata_kuliah = $request->nama_mata_kuliah;
        $pengajaran->kode_mata_kuliah = $request->kode_mata_kuliah;
        $pengajaran->jumlah_sks = $request->jumlah_sks;
        $pengajaran->semester = $request->semester;
        $pengajaran->tahun_ajaran = $request->tahun_ajaran;
        $pengajaran->jumlah_pertemuan = $request->jumlah_pertemuan;

        if ($request->hasFile('file_bukti')) {
            $paths = [];
            foreach ($request->file('file_bukti') as $file) {
                $paths[] = $file->store('pengajaran/bukti', 'public');
            }
            $pengajaran->file_bukti = json_encode($paths);
        }

        $pengajaran->save();

        return redirect()->back()->with('success', 'Data pengajaran berhasil ditambahkan.');
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
        ]);

        $pengajaran = Pengajaran::findOrFail($id);
        $pengajaran->nama_mata_kuliah = $request->nama_mata_kuliah;
        $pengajaran->kode_mata_kuliah = $request->kode_mata_kuliah;
        $pengajaran->jumlah_sks = $request->jumlah_sks;
        $pengajaran->semester = $request->semester;
        $pengajaran->tahun_ajaran = $request->tahun_ajaran;
        $pengajaran->jumlah_pertemuan = $request->jumlah_pertemuan;

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


    public function userPenunjang()
    {
        $userId = Auth::id(); // ambil ID user yang sedang login

        // hanya ambil data usulan milik user yang login
        $penunjang = Penunjang::with('users')
            ->where('user_id', $userId)
            ->paginate(20);
        $userPenunjang = 'active';
        return view('kinerja.penunjang-user', compact('userPenunjang','penunjang'));
    }

    public function storePenunjang(Request $request)
    {
        $data = $request->validate([
            'jenis_kegiatan' => 'required',
            'nama_kegiatan' => 'required',
            'tingkat_kegiatan' => 'required',
            'tanggal_kegiatan' => 'required|date',
            'institusi_penyelenggara' => 'required',
            'file_bukti.*' => 'file|mimes:pdf,doc,docx|max:20480',
        ]);

        $data['user_id'] = auth()->id();

        if ($request->hasFile('file_bukti')) {
            $paths = [];
            foreach ($request->file('file_bukti') as $file) {
                $paths[] = $file->store('penunjang/file_bukti', 'public');
            }
            $data['file_bukti'] = json_encode($paths);
        }

        Penunjang::create($data);
        return redirect()->back()->with('success', 'Data berhasil ditambahkan.');
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
}
