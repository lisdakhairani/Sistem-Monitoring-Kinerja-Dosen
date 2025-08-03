<?php

namespace App\Http\Controllers;

use App\Models\SeminarProposal;
use App\Models\SidangTesis;
use App\Models\Pembimbing;
use App\Models\User;
use App\Models\Dokumen;
use App\Models\UsulanJudul;
use Illuminate\Http\Request;
use App\Models\JadwalSeminar;
use App\Models\JadwalSidang;
use Illuminate\Support\Facades\Storage;

class AdminTesisController extends Controller
{
  public function adminjudul()
    {
        $usulanJudul = UsulanJudul::with('users')->paginate(20);
        $menuAdminUsulan = 'active';
        return view('home.pendaftaran.usulan_judul', compact('menuAdminUsulan','usulanJudul'));
    }


    public function lihatDokumen($id, $jenis)
{
    $data = UsulanJudul::findOrFail($id);

    switch ($jenis) {
        case 'proposal':
            $path = 'usulan/proposal/' . $data->proposal_tesis;
            break;
        case 'internasional':
            $path = 'usulan/jurnal/internasional/' . $data->jurnal_internasional;
            break;
        case 'nasional':
            $path = 'usulan/jurnal/nasional/' . $data->jurnal_nasional;
            break;
        default:
            abort(404);
    }

    return view('home.pendaftaran.dokumen', [
        'judul' => ucfirst($jenis),
        'filePath' => asset('storage/app/public/' . $path)
    ]);
}

     

        public function adminSeminar()
    {
        $data = SeminarProposal::with('users')->paginate(20);
        $menuAdminSeminar = 'active';
        return view('home.pendaftaran.seminar_tesis', compact('menuAdminSeminar','data'));
    }

      public function adminSidang()
    {
        $dataSidang = SidangTesis::with('users')->paginate(20);
        $menuAdminSidang = 'active';
        return view('home.pendaftaran.sidang_tesis', compact('menuAdminSidang','dataSidang'));
    }

    public function setStatus(Request $request, $id)
{
    $data = UsulanJudul::findOrFail($id);
    $status = $request->status;

    if ($status === 'tidak' && empty($data->catatan_admin)) {
        return back()->with('error', 'Catatan wajib diisi saat menolak usulan.');
    }

    $data->status = $status;
    $data->save();

    return back()->with('success', 'Status berhasil diperbarui.');
}


public function formCatatan($id)
{
    $data = UsulanJudul::findOrFail($id);
    return view('home.pendaftaran.catatan.usulan', compact('data'));
}


public function setCatatan(Request $request, $id)
{
    $request->validate([
        'catatan_admin' => 'required|string|max:1000',
    ]);

    $data = UsulanJudul::findOrFail($id);
    $data->catatan_admin = $request->catatan_admin;
    $data->save();

    return redirect()->route('usulan.adminJudul')->with('success', 'Catatan berhasil disimpan.');
}

    



public function lihatDokumenSeminar($id, $jenis)
{
    $data = SeminarProposal::findOrFail($id);

    switch ($jenis) {
        case 'proposal':
            $path = 'seminar/' . $data->proposal_tesis;
            break;
        case 'persetujuan':
            $path = 'seminar/' . $data->surat_persetujuan_seminar;
            break;
        case 'koreksi':
            $path = 'seminar/' . $data->lembar_koreksi_pembimbing;
            break;
        case 'slide':
            $path = $data->slide_seminar ? 'seminar/' . $data->slide_seminar : null;
            break;
        case 'keikutsertaan':
            $path = 'seminar/' . $data->bukti_keikutsertaan_seminar;
            break;
        case 'spp':
            $path = 'seminar/' . $data->bukti_setor_spp;
            break;
        case 'plagiasi':
            $path = 'seminar/' . $data->bukti_cek_plagiasi;
            break;
        default:
            abort(404);
    }

    

    return view('home.pendaftaran.dokumen', [
        'judul' => ucfirst($jenis),
        'filePath' => asset('storage/' . $path)
    ]);
}

public function lihatDokumenSidang($id, $jenis)
{
    $data = SidangTesis::findOrFail($id);

    $jenisMapping = [
        'permohonan' => $data->surat_permohonan_sidang,
        'persetujuan' => $data->surat_persetujuan_sidang,
        'koreksi' => $data->lembar_koreksi_pembimbing,
        'matriks' => $data->matriks_perbaikan_proposal,
        'revisi' => $data->surat_revisi_proposal,
        'spp' => $data->bukti_setor_spp,
        'toefl' => $data->toefl,
        'ktm' => $data->kartu_identitas_mahasiswa,
        'foto' => $data->foto_3x4,
        'artikel' => $data->artikel,
        'tesis' => $data->tesis_lengkap,
        'plagiasi' => $data->bukti_bebas_plagiasi,
        'slide' => $data->slide_sidang,
        'ktp' => $data->ktp,
        'ijazah' => $data->ijazah_s1,
        'transkrip' => $data->transkrip_validasi,
    ];

    if (!isset($jenisMapping[$jenis])) {
        abort(404);
    }

    return view('home.pendaftaran.dokumen', [
        'judul' => ucfirst($jenis),
        'filePath' => asset('storage/sidang/' . $jenisMapping[$jenis]),
    ]);
}


    public function adminJadwalSeminar()
        {
            $jadwalseminar = JadwalSeminar::latest()->get();;
            $menuAdminJadwalSeminar = 'active';
            return view('home.pendaftaran.jadwal.seminar', compact('menuAdminJadwalSeminar','jadwalseminar'));
        }
    public function storeJadwalSeminar(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'file_pdf' => 'required|mimes:pdf|max:2048',
        ]);

        // Simpan file
        $fileName = time() . '_' . $request->file_pdf->getClientOriginalName();
        $request->file_pdf->storeAs('public/jadwal-seminar', $fileName);

        // Simpan ke database
        JadwalSeminar::create([
            'judul' => $request->judul,
            'file_pdf' => $fileName,
        ]);

        return redirect()->route('seminar.adminjadwalseminar')->with('success', 'Jadwal seminar berhasil ditambahkan.');
    }

    /**
     * Update data dari form modal edit.
     */
    public function updateJadwalSeminar(Request $request, JadwalSeminar $jadwal_seminar)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'file_pdf' => 'nullable|mimes:pdf|max:2048',
        ]);

        // Jika user mengupload file baru
        if ($request->hasFile('file_pdf')) {
            // Hapus file lama dari storage
            if ($jadwal_seminar->file_pdf && Storage::exists('public/jadwal-seminar/' . $jadwal_seminar->file_pdf)) {
                Storage::delete('public/jadwal-seminar/' . $jadwal_seminar->file_pdf);
            }

            // Simpan file baru
            $fileName = time() . '_' . $request->file_pdf->getClientOriginalName();
            $request->file_pdf->storeAs('public/jadwal-seminar', $fileName);
        } else {
            $fileName = $jadwal_seminar->file_pdf; // pakai file lama
        }

        // Update database
        $jadwal_seminar->update([
            'judul' => $request->judul,
            'file_pdf' => $fileName,
        ]);

        return redirect()->route('seminar.adminjadwalseminar')->with('success', 'Data berhasil diupdate.');
    }

    /**
     * Hapus data dan file-nya.
     */
   public function deleteJadwalSeminar($id)
{
    $jadwal_seminar = JadwalSeminar::findOrFail($id);

    if ($jadwal_seminar->file_pdf && Storage::exists('public/jadwal-seminar/' . $jadwal_seminar->file_pdf)) {
        Storage::delete('public/jadwal-seminar/' . $jadwal_seminar->file_pdf);
    }

    $jadwal_seminar->delete();

    return redirect()->route('seminar.adminjadwalseminar')->with('success', 'Data berhasil dihapus.');
}


public function adminJadwalSidang()
    {
        $jadwalsidang = JadwalSidang::all();
        $menuAdminJadwalSidang = 'active';
        return view('home.pendaftaran.jadwal.sidang', compact('menuAdminJadwalSidang','jadwalsidang'));
    }

public function storeJadwalSidang(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'file_pdf' => 'required|mimes:pdf|max:2048',
        ]);

        // Simpan file
        $fileName = time() . '_' . $request->file_pdf->getClientOriginalName();
        $request->file_pdf->storeAs('public/jadwal-sidang', $fileName);

        // Simpan ke database
        JadwalSidang::create([
            'judul' => $request->judul,
            'file_pdf' => $fileName,
        ]);

        return redirect()->route('sidang.adminjadwalsidang')->with('success', 'Jadwal sidang berhasil ditambahkan.');
    }

    /**
     * Update data dari form modal edit.
     */
    public function updateJadwalSidang(Request $request, JadwalSidang $jadwal_sidang)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'file_pdf' => 'nullable|mimes:pdf|max:2048',
        ]);

        // Jika user mengupload file baru
        if ($request->hasFile('file_pdf')) {
            // Hapus file lama dari storage
            if ($jadwal_sidang->file_pdf && Storage::exists('public/jadwal-sidang/' . $jadwal_sidang->file_pdf)) {
                Storage::delete('public/jadwal-sidang/' . $jadwal_sidang->file_pdf);
            }

            // Simpan file baru
            $fileName = time() . '_' . $request->file_pdf->getClientOriginalName();
            $request->file_pdf->storeAs('public/jadwal-sidang', $fileName);
        } else {
            $fileName = $jadwal_sidang->file_pdf; // pakai file lama
        }

        // Update database
        $jadwal_sidang->update([
            'judul' => $request->judul,
            'file_pdf' => $fileName,
        ]);

        return redirect()->route('sidang.adminjadwalsidang')->with('success', 'Data berhasil diupdate.');
    }

    /**
     * Hapus data dan file-nya.
     */
   public function deleteJadwalSidang($id)
{
    $jadwal_sidang = JadwalSidang::findOrFail($id);

    if ($jadwal_sidang->file_pdf && Storage::exists('public/jadwal-sidang/' . $jadwal_sidang->file_pdf)) {
        Storage::delete('public/jadwal-sidang/' . $jadwal_sidang->file_pdf);
    }

    $jadwal_sidang->delete();

    return redirect()->route('sidang.adminjadwalsidang')->with('success', 'Data berhasil dihapus.');
}

public function adminPembimbing() 
{
    $menuAdminPembimbing = 'active';
    $pembimbingData = Pembimbing::orderBy('tanggal', 'desc')->get();
    return view('home.pendaftaran.pembimbing', compact('pembimbingData', 'menuAdminPembimbing'));
}

public function storePembimbing(Request $request)
{
    $validated = $request->validate([
        'judul' => 'required|string',
        'tanggal' => 'required|date',
        'file' => 'required|file|mimes:pdf,doc,docx|max:2048',
    ]);

    $file = $request->file('file')->store('pembimbing', 'public');

    Pembimbing::create([
        'judul' => $request->judul,
        'tanggal' => $request->tanggal,
        'file' => basename($file),
    ]);

    return redirect()->back()->with('success', 'Data pembimbing berhasil ditambahkan.');
}


public function updatePembimbing(Request $request, $id)
{
    $pembimbing = Pembimbing::findOrFail($id);

    $data = $request->validate([
        'judul' => 'required',
        'tanggal' => 'required',
        'file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
    ]);

    if ($request->hasFile('file')) {
        Storage::disk('public')->delete('pembimbing/' . $pembimbing->file);
        $data['file'] = basename($request->file('file')->store('pembimbing', 'public'));
    }

    $pembimbing->update($data);

    return redirect()->back()->with('success', 'Data pembimbing berhasil diperbarui.');
}

public function destroyPembimbing($id)
{
    $pembimbing = Pembimbing::findOrFail($id);
    Storage::disk('public')->delete('pembimbing/' . $pembimbing->file);
    $pembimbing->delete();

    return redirect()->back()->with('success', 'Data pembimbing berhasil dihapus.');
}
 
public function adminDokumen() 
{
    $menuAdminDokumen = 'active';
    $dokumen = Dokumen::orderBy('tanggal', 'desc')->get();
    return view('home.pendaftaran.dokumen', compact('dokumen', 'menuAdminDokumen'));
}

public function storeDokumen(Request $request)
{
    $validated = $request->validate([
        'judul' => 'required|string',
        'tanggal' => 'required|date',
        'file' => 'required|file|mimes:pdf,doc,docx|max:2048',
    ]);

    $file = $request->file('file')->store('dokumen', 'public');

    Dokumen::create([
        'judul' => $request->judul,
        'tanggal' => $request->tanggal,
        'file' => basename($file),
    ]);

    return redirect()->back()->with('success', 'Dokumen berhasil ditambahkan.');
}

public function updateDokumen(Request $request, $id)
{
    $dokumen = Dokumen::findOrFail($id);

    $validated = $request->validate([
        'judul' => 'required|string',
        'tanggal' => 'required|date',
        'file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
    ]);

    if ($request->hasFile('file')) {
        Storage::disk('public')->delete('dokumen/' . $dokumen->file);
        $validated['file'] = basename($request->file('file')->store('dokumen', 'public'));
    }

    $dokumen->update($validated);

    return redirect()->back()->with('success', 'Dokumen berhasil diperbarui.');
}

public function deleteDokumen($id)
{
    $dokumen = Dokumen::findOrFail($id);
    Storage::disk('public')->delete('dokumen/' . $dokumen->file);
    $dokumen->delete();

    return redirect()->back()->with('success', 'Dokumen berhasil dihapus.');
}

public function progressMahasiswa()
{
    $menuAdminStatus = 'active';
    // Ambil semua user mahasiswa beserta relasi konfirmasi
    $mahasiswa = User::where('is_admin', 0)->with('konfirmasi')->get();

    return view('home.pendaftaran.progress', compact('mahasiswa', 'menuAdminStatus'));
}


}



?>