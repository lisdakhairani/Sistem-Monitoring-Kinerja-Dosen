@extends('layouts.admin_template')
@section('title', 'Pengajaran')

@section('content')
<div class="container py-4">
    <h3 class="mb-4">Data <span style="color: #008374">Pengajaran</span></h3>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Mata Kuliah</th>
                    <th>Kode MK</th>
                    <th>Jumlah SKS</th>
                    <th>Semester</th>
                    <th>Tahun Ajaran</th>
                    <th>Jumlah Pertemuan</th>
                    <th>File Bukti</th>
                    <th>Penilaian</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pengajaran as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->nama_mata_kuliah }}</td>
                    <td>{{ $item->kode_mata_kuliah }}</td>
                    <td>{{ $item->jumlah_sks }}</td>
                    <td>{{ $item->semester }}</td>
                    <td>{{ $item->tahun_ajaran }}</td>
                    <td>{{ $item->jumlah_pertemuan }}</td>
                    <td>
                        @foreach(json_decode($item->file_bukti ?? '[]') as $i => $file)
                            <a href="{{ asset('storage/' . $file) }}" target="_blank">Lihat Bukti {{ $i + 1 }}</a><br>
                        @endforeach
                    </td>
                    <td>
                       @if($item->nilai)
            {{ $item->nilai }}
        @else
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalNilai{{ $item->id }}">
                Beri Nilai
            </button>
    
    <!-- Modal Nilai Harus di Sini -->
    <div class="modal fade" id="modalNilai{{ $item->id }}" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ route('Penunjang.nilai', $item->id) }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Beri Nilai Penunjang</h5>
                        <button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <label for="penilaian" class="form-label">Nilai (1–10):</label>
                        <input type="number" name="penilaian" class="form-control" min="1" max="10" required>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-success">Simpan Nilai</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endif

                    </td>
                    <td>
                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $item->id }}">Edit</button>

                        <form action="{{ route('Pengajaran.delete', $item->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>

                <!-- Modal Edit -->
                <div class="modal fade" id="modalEdit{{ $item->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <form action="{{ route('Pengajaran.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Pengajaran</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <input name="nama_mata_kuliah" value="{{ $item->nama_mata_kuliah }}" class="form-control mb-2" placeholder="Nama Mata Kuliah">
                                    <input name="kode_mata_kuliah" value="{{ $item->kode_mata_kuliah }}" class="form-control mb-2" placeholder="Kode Mata Kuliah">
                                    <input name="jumlah_sks" value="{{ $item->jumlah_sks }}" class="form-control mb-2" placeholder="Jumlah SKS">
                                    <input name="semester" value="{{ $item->semester }}" class="form-control mb-2" placeholder="Semester">
                                    <input name="tahun_ajaran" value="{{ $item->tahun_ajaran }}" class="form-control mb-2" placeholder="Tahun Ajaran">
                                    <input name="jumlah_pertemuan" value="{{ $item->jumlah_pertemuan }}" class="form-control mb-2" placeholder="Jumlah Pertemuan">
                                    <input name="file_bukti[]" type="file" class="form-control mb-2" multiple>
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
        <form action="{{ route('Pengajaran.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Pengajaran</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input name="nama_mata_kuliah" class="form-control mb-2" placeholder="Nama Mata Kuliah">
                    <input name="kode_mata_kuliah" class="form-control mb-2" placeholder="Kode Mata Kuliah">
                    <input name="jumlah_sks" class="form-control mb-2" placeholder="Jumlah SKS">
                    <input name="semester" class="form-control mb-2" placeholder="Semester">
                    <input name="tahun_ajaran" class="form-control mb-2" placeholder="Tahun Ajaran">
                    <input name="jumlah_pertemuan" class="form-control mb-2" placeholder="Jumlah Pertemuan">
                    <div class="mb-3">
                        <label for="file_bukti" class="form-label">File Bukti</label>
                        <input type="file" name="file_bukti[]" class="form-control" multiple>
                    </div>
                    <input name="nilai" value="{{ $item->nilai }}" class="form-control mb-2" placeholder="Nilai">
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>




@endsection
