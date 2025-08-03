@extends('layouts.admin_template')
@section('title', 'Penunjang Lainnya')

@section('content')
<div class="container py-4">
    <h3 class="mb-4">Data <span style="color: #008374">Penunjang Lainnya</span></h3>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#modalTambah">
        <i class="bi bi-plus-circle"></i> Tambah Penunjang
    </button>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Jenis Kegiatan</th>
                    <th>Nama Kegiatan</th>
                    <th>Tingkat</th>
                    <th>Tanggal</th>
                    <th>Institusi</th>
                    <th>File Bukti</th>
                    <th>Penilaian</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($penunjang as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->jenis_kegiatan }}</td>
                    <td>{{ $item->nama_kegiatan }}</td>
                    <td>{{ $item->tingkat_kegiatan }}</td>
                    <td>{{ $item->tanggal_kegiatan }}</td>
                    <td>{{ $item->institusi_penyelenggara }}</td>
                    <td>
                        @foreach(json_decode($item->file_bukti ?? '[]') as $i => $file)
                            <a href="{{ asset('storage/' . $file) }}" target="_blank">Bukti {{ $i + 1 }}</a><br>
                        @endforeach
                    </td>
                    <td>{{ $item->nilai }}</td>
                    <td>
                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $item->id }}">Edit</button>
                        <form action="{{ route('Penunjang.delete', $item->id) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>

                <!-- Modal Edit -->
                <div class="modal fade" id="modalEdit{{ $item->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <form action="{{ route('Penunjang.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf @method('PUT')
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Penunjang</h5>
                                    <button class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <select name="jenis_kegiatan" class="form-control mb-2">
                                        <option {{ $item->jenis_kegiatan == 'reviewer jurnal' ? 'selected' : '' }}>reviewer jurnal</option>
                                        <option {{ $item->jenis_kegiatan == 'narasumber/moderator' ? 'selected' : '' }}>narasumber/moderator</option>
                                        <option {{ $item->jenis_kegiatan == 'panitia kegiatan ilmiah' ? 'selected' : '' }}>panitia kegiatan ilmiah</option>
                                        <option {{ $item->jenis_kegiatan == 'pembicara seminar' ? 'selected' : '' }}>pembicara seminar</option>
                                        <option {{ $item->jenis_kegiatan == 'anggota organisasi profesi' ? 'selected' : '' }}>anggota organisasi profesi</option>
                                        <option {{ $item->jenis_kegiatan == 'sertifikasi kompetensi' ? 'selected' : '' }}>sertifikasi kompetensi</option>
                                        <!-- tambah opsi lainnya sesuai enum -->
                                    </select>
                                    <input name="nama_kegiatan" value="{{ $item->nama_kegiatan }}" class="form-control mb-2" placeholder="Nama Kegiatan">
                                    <select name="tingkat_kegiatan" class="form-control mb-2">
                                        <option {{ $item->tingkat_kegiatan == 'Lokal' ? 'selected' : '' }}>Lokal</option>
                                        <option {{ $item->tingkat_kegiatan == 'Nasional' ? 'selected' : '' }}>Nasional</option>
                                        <option {{ $item->tingkat_kegiatan == 'Internasional' ? 'selected' : '' }}>Internasional</option>
                                    </select>
                                    <input type="date" name="tanggal_kegiatan" value="{{ $item->tanggal_kegiatan }}" class="form-control mb-2">
                                    <input name="institusi_penyelenggara" value="{{ $item->institusi_penyelenggara }}" class="form-control mb-2" placeholder="Institusi Penyelenggara">
                                    <input type="file" name="file_bukti[]" class="form-control mb-2" multiple>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-primary">Simpan Perubahan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('Penunjang.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Penunjang</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <select name="jenis_kegiatan" class="form-control mb-2">
                        <option>reviewer jurnal</option>
                        <option>narasumber/moderator</option>
                        <option>panitia kegiatan ilmiah</option>
                        <option>pembicara seminar</option>
                        <option>anggota organisasi profesi</option>
                        <option>sertifikasi kompetensi</option>
                        <!-- tambahkan lainnya sesuai enum -->
                    </select>
                    <input name="nama_kegiatan" class="form-control mb-2" placeholder="Nama Kegiatan">
                    <select name="tingkat_kegiatan" class="form-control mb-2">
                        <option>Lokal</option>
                        <option>Nasional</option>
                        <option>Internasional</option>
                    </select>
                    <input type="date" name="tanggal_kegiatan" class="form-control mb-2">
                    <input name="institusi_penyelenggara" class="form-control mb-2" placeholder="Institusi Penyelenggara">
                    <input type="file" name="file_bukti[]" class="form-control mb-2" multiple>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
