@extends('layouts.admin_template')
@section('title', 'Penelitian')

@section('content')
<div class="container py-4">
    <h3 class="mb-4">Data <span style="color: #008374">Penelitian</span></h3>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Form Filter -->
    <form method="GET" action="{{ route('Penelitian.index') }}" class="mb-3 d-flex gap-2">
        <input type="text" name="search" class="form-control" placeholder="Cari Judul atau Tahun..." value="{{ request('search') }}">
        <button type="submit" class="btn btn-primary">Filter</button>
        <a href="{{ route('Penelitian.index') }}" class="btn btn-secondary">Reset</a>
    </form>

    <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#modalTambah">
        <i class="bi bi-plus-circle"></i> Tambah Penelitian
    </button>

    <div class="table-responsive">
        <table class="table table-striped align-middle">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul</th>
                    <th>Jenis</th>
                    <th>Peran</th>
                    <th>Tahun</th>
                    <th>Status</th>
                    <th>Output</th>
                    <th>Bukti</th>
                    <th>Nilai</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($penelitian as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->judul_penelitian }}</td>
                    <td>{{ $item->jenis_penelitian }}</td>
                    <td>{{ $item->peran }}</td>
                    <td>{{ $item->tahun_kegiatan }}</td>
                    <td>{{ $item->status }}</td>
                    <td>
                        @foreach(json_decode($item->output ?? '[]') as $i => $file)
                            <a href="{{ asset('storage/' . $file) }}" target="_blank">Lihat Output {{ $i + 1 }}</a><br>
                        @endforeach
                    </td>
                    <td>
                        @foreach(json_decode($item->file_bukti ?? '[]') as $i => $file)
                            <a href="{{ asset('storage/' . $file) }}" target="_blank">Lihat Bukti {{ $i + 1 }}</a><br>
                        @endforeach
                    </td>
                    <td>{{ $item->nilai }}</td>
                    <td>
                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $item->id }}">Edit</button>

                        <form action="{{ route('Penelitian.delete', $item->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                        </form>
                    </td>
                    
                </tr>

                <!-- Modal Edit -->
                <div class="modal fade" id="modalEdit{{ $item->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <form action="{{ route('Penelitian.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Penelitian</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <input name="judul_penelitian" value="{{ $item->judul_penelitian }}" class="form-control mb-2" placeholder="Judul Penelitian">
                                    <input name="jenis_penelitian" value="{{ $item->jenis_penelitian }}" class="form-control mb-2" placeholder="Jenis">
                                    <input name="peran" value="{{ $item->peran }}" class="form-control mb-2" placeholder="Peran">
                                    <input name="tahun_kegiatan" value="{{ $item->tahun_kegiatan }}" class="form-control mb-2" placeholder="Tahun">
                                    <select name="status" class="form-control mb-2">
                                        <option value="Sedang Berjalan" {{ $item->status == 'Sedang Berjalan' ? 'selected' : '' }}>Sedang Berjalan</option>
                                        <option value="Selesai" {{ $item->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                    </select>
                                    <input name="output[]" type="file" class="form-control mb-2" multiple>
                                    <input name="file_bukti[]" type="file" class="form-control mb-2" multiple>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-primary">Simpan Perubahan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                @empty
                <tr><td colspan="10" class="text-center">Data tidak ditemukan</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('Penelitian.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Penelitian</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input name="judul_penelitian" class="form-control mb-2" placeholder="Judul Penelitian">
                    <input name="jenis_penelitian" class="form-control mb-2" placeholder="Jenis">
                    <input name="peran" class="form-control mb-2" placeholder="Peran">
                    <input name="tahun_kegiatan" class="form-control mb-2" placeholder="Tahun">
                    <select name="status" class="form-control mb-2">
                        <option value="Sedang Berjalan">Sedang Berjalan</option>
                        <option value="Selesai">Selesai</option>
                    </select>
                    <div class="mb-3">
                        <label for="output" class="form-label">Output (PDF atau dokumen lain)</label>
                        <input type="file" name="output[]" class="form-control" multiple>
                    </div>
                    <div class="mb-3">
                        <label for="file_bukti" class="form-label">File Bukti</label>
                        <input type="file" name="file_bukti[]" class="form-control" multiple>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
