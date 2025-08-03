<?php

namespace App\Http\Controllers;

use App\Models\SeminarProposal;
use App\Models\SidangTesis;
use App\Models\Pembimbing;
use App\Models\Dokumen;
use App\Models\Konfirmasi;
use App\Models\UsulanJudul;
use App\Models\JadwalSidang;
use App\Models\JadwalSeminar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TesisController extends Controller
{
  public function userJudul()
{
    $userId = Auth::id(); // ambil ID user yang sedang login

    // hanya ambil data usulan milik user yang login
    $usulanJudul = UsulanJudul::with('users')
        ->where('user_id', $userId)
        ->paginate(20);

    $menuUserUsulan = 'active';

    return view('home.pendaftaran.user.usulan_judul', compact('menuUserUsulan','usulanJudul'));
}
    

   public function userSeminar()
{
    $userId = Auth::id(); // Ambil ID user yang sedang login

    $SeminarProposal = SeminarProposal::with('users')
        ->where('user_id', $userId) // Filter berdasarkan user login
        ->paginate(20);

    $menuUserSeminarDaftar = 'active';

    return view('home.pendaftaran.user.seminar_tesis', compact('menuUserSeminarDaftar', 'SeminarProposal'));
}

     public function usersidang()
{
    $userId = Auth::id(); // Ambil ID user yang sedang login

    $sidangtesis = SidangTesis::with('users')
        ->where('user_id', $userId) // Filter berdasarkan user login
        ->paginate(20);

    $menuUserSidangDaftar = 'active';

    return view('home.pendaftaran.user.sidang_tesis', compact('menuUserSidangDaftar', 'sidangtesis'));
}

        public function createUsulan()
    {
        return view('home.pendaftaran.create.usulan_judul');
    }

     public function createSeminar()
    {
        return view('home.pendaftaran.create.daftar-seminar');
    }

     public function createSidang()
    {
        return view('home.pendaftaran.create.daftar-sidang');
    }

    public function storeUsulan(Request $request)
    {
        $request->validate([
            'nim' => 'required',
            'no_hp' => 'required',
            'konsentrasi' => 'required',
            'proposal_tesis' => 'required|file|mimes:pdf|max:102400',
            'jurnal_internasional.*' => 'required|file|mimes:pdf|max:10240',
            'jurnal_nasional.*' => 'required|file|mimes:pdf|max:10240',
        ]);

        $data = new UsulanJudul();
        $data->user_id = auth()->id();
        $data->nama = auth()->user()->name;
        $data->email = auth()->user()->email;
        $data->nim = $request->nim;
        $data->no_hp = $request->no_hp;
        $data->konsentrasi = $request->konsentrasi;
        $data->proposal_tesis = $request->file('proposal_tesis')->store('usulan/proposal');

        // Menyimpan file jurnal sebagai JSON array of filenames
        $jurnalInternasional = [];
        foreach ($request->file('jurnal_internasional') as $file) {
            $jurnalInternasional[] = $file->store('usulan/jurnal/internasional');
        }
        $data->jurnal_internasional = json_encode($jurnalInternasional);

        $jurnalNasional = [];
        foreach ($request->file('jurnal_nasional') as $file) {
            $jurnalNasional[] = $file->store('usulan/jurnal/nasional');
        }
        $data->jurnal_nasional = json_encode($jurnalNasional);

        $data->save();

        return redirect()->route('usulan.userJudul')->with('success', 'Usulan judul berhasil dikirim.');
    }

    public function storeSeminar(Request $request)
    {
        $request->validate([
            'nim' => 'required',
            'no_hp' => 'required',
            'konsentrasi' => 'required',
            'proposal_tesis' => 'required|file|mimes:pdf|max:10240',
            'surat_persetujuan_seminar' => 'required|file|mimes:pdf|max:10240',
            'lembar_koreksi_pembimbing' => 'required|file|mimes:pdf|max:10240',
            'bukti_setor_spp' => 'required|file|mimes:pdf|max:10240',
            'bukti_keikutsertaan_seminar' => 'required|file|mimes:pdf|max:10240',
            'bukti_cek_plagiasi' => 'required|file|mimes:pdf|max:10240',
            'slide_seminar' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        $data = new SeminarProposal();
        $data->user_id = auth()->id();
        $data->nama_mahasiswa = auth()->user()->name;
        $data->email = auth()->user()->email;
        $data->alamat_email = auth()->user()->email;
        $data->nim = $request->nim;
        $data->no_hp = $request->no_hp;
        $data->konsentrasi = $request->konsentrasi;

        // Upload dokumen
        $data->proposal_tesis = $request->file('proposal_tesis')->store('seminar');
        $data->surat_persetujuan_seminar = $request->file('surat_persetujuan_seminar')->store('seminar');
        $data->lembar_koreksi_pembimbing = $request->file('lembar_koreksi_pembimbing')->store('seminar');
        $data->bukti_setor_spp = $request->file('bukti_setor_spp')->store('seminar');
        $data->bukti_keikutsertaan_seminar = $request->file('bukti_keikutsertaan_seminar')->store('seminar');
        $data->bukti_cek_plagiasi = $request->file('bukti_cek_plagiasi')->store('seminar');
        

        if ($request->hasFile('slide_seminar')) {
            $data->slide_seminar = $request->file('slide_seminar')->store('seminar');
        }

        $data->tanggal_submit = now();
        $data->save();

        return redirect()->route('seminar.userSeminar')->with('success', 'Pendaftaran seminar proposal berhasil.');
    }

    public function storeSidang(Request $request)
{
    $request->validate([
        'nim_mahasiswa' => 'required',
        'no_hp' => 'required',
        'kosentrasi' => 'required',
        // Validasi untuk semua dokumen yang wajib diupload
        'surat_permohonan_sidang' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
        'surat_persetujuan_sidang' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
        'lembar_koreksi_pembimbing' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
        'matriks_perbaikan_proposal' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
        'surat_revisi_proposal' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
        'bukti_setor_spp' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
        'toefl' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
        'kartu_identitas_mahasiswa' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
        'foto_3x4' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
        'artikel' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
        'tesis_lengkap' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
        'bukti_bebas_plagiasi' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
        'slide_sidang' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
        'ktp' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
        'ijazah_s1' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
        'transkrip_validasi' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
    ]);

    $data = new SidangTesis();
    $data->user_id = auth()->id();
    $data->nama_mahasiswa = auth()->user()->name;
    $data->email = auth()->user()->email;
    $data->nim_mahasiswa = $request->nim_mahasiswa;
    $data->no_hp = $request->no_hp;
    $data->kosentrasi = $request->kosentrasi;

    // Simpan file satu per satu ke dalam folder `sidang/`
    $dokumen = [
        'surat_permohonan_sidang',
        'surat_persetujuan_sidang',
        'lembar_koreksi_pembimbing',
        'matriks_perbaikan_proposal',
        'surat_revisi_proposal',
        'bukti_setor_spp',
        'toefl',
        'kartu_identitas_mahasiswa',
        'foto_3x4',
        'artikel',
        'tesis_lengkap',
        'bukti_bebas_plagiasi',
        'slide_sidang',
        'ktp',
        'ijazah_s1',
        'transkrip_validasi'
    ];

    foreach ($dokumen as $field) {
        if ($request->hasFile($field)) {
            $data->$field = $request->file($field)->store("sidang/$field");
        }
    }

    $data->tanggal_submit = now();
    $data->save();

    return redirect()->route('sidang.userSidang')->with('success', 'Pendaftaran sidang tesis berhasil.');
}

public function jadwalSeminar()
{
    $jadwalseminar = JadwalSeminar::latest()->get();
    $menuUserJadwalSeminar = 'active';
    return view('home.pendaftaran.user.jadwal.seminar', compact('menuUserJadwalSeminar','jadwalseminar'));
}

public function jadwalSidang()
{
    $jadwalsidang = JadwalSidang::latest()->get();
    $menuUserSidangJadwal= 'active';
    return view('home.pendaftaran.user.jadwal.sidang', compact('menuUserSidangJadwal', 'jadwalsidang'));
}

public function userPembimbing() 
{
    $menuUserPembimbing = 'active';
    $pembimbingData = Pembimbing::orderBy('tanggal', 'desc')->get();
    return view('home.pendaftaran.user.pembimbing', compact('pembimbingData', 'menuUserPembimbing'));
}



public function userDokumen() 
{
    $menuUserDokumen = 'active';
    $dokumen = Dokumen::orderBy('tanggal', 'desc')->get();
    return view('home.pendaftaran.user.dokumen', compact('dokumen', 'menuUserDokumen'));
}

public function userStatus()
{
    $menuUserStatus = 'active';

    // Ambil user yang sedang login
    $user = auth()->user();

    // Ambil data konfirmasi user
    $konfirmasi = Konfirmasi::where('user_id', $user->id)->first();

    // Jika belum pernah konfirmasi, inisialisasi default kosong (biar nggak error)
    if (!$konfirmasi) {
        $konfirmasi = (object)[
            'pembimbing_konfirmasi' => false,
            'seminar_konfirmasi' => false,
            'sidang_konfirmasi' => false,
            'yudisium_konfirmasi' => false,
        ];
    }

    return view('home.pendaftaran.user.status', compact('konfirmasi', 'menuUserStatus'));
}

public function formKonfirmasi()
{
    $user = auth()->user();
    $konfirmasi = Konfirmasi::firstOrNew(['user_id' => $user->id]);

    return view('home.pendaftaran.user.konfirmasi.form', compact('konfirmasi'));
}

public function updateKonfirmasi(Request $request)
{
    $user = auth()->user();

    Konfirmasi::updateOrCreate(
        ['user_id' => $user->id],
        [
            'pembimbing_konfirmasi' => $request->has('pembimbing_konfirmasi'),
            'seminar_konfirmasi' => $request->has('seminar_konfirmasi'),
            'sidang_konfirmasi' => $request->has('sidang_konfirmasi'),
            'yudisium_konfirmasi' => $request->has('yudisium_konfirmasi'),
        ]
    );

    return redirect()->route('userStatus')->with('success', 'Status berhasil diperbarui');
}


}



?>