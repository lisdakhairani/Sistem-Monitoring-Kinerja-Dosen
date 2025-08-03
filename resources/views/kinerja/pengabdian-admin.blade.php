@extends('layouts.admin_template')
@section('title', 'Pengabdian')

@section('content')
<div class="container py-4">
    <h3 class="mb-4">Data <span style="color: #008374">Pengabdian</span></h3>

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
                    <th>Judul Kegiatan</th>
                    <th>Jenis</th>
                    <th>Peran</th>
                    <th>Lokasi</th>
                    <th>Tahun</th>
                    <th>Sumber Dana</th>
                    <th>Jumlah Dana</th>
                    <th>Output</th>
                    <th>Bukti</th>
                    <th>Penilaian</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pengabdian as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->judul_kegiatan }}</td>
                    <td>{{ $item->jenis_kegiatan }}</td>
                    <td>{{ $item->peran }}</td>
                    <td>{{ $item->lokasi }}</td>
                    <td>{{ $item->tahun_kegiatan }}</td>
                    <td>{{ $item->sumber_dana }}</td>
                    <td>{{ $item->jumlah_dana }}</td>
                    <td>
                        @foreach(json_decode($item->output ?? '[]') as $i => $file)
                            <a href="{{ asset('storage/' . $file) }}" target="_blank">Output {{ $i + 1 }}</a><br>
                        @endforeach
                    </td>
                    <td>
                        @foreach(json_decode($item->file_bukti ?? '[]') as $i => $file)
                            <a href="{{ asset('storage/' . $file) }}" target="_blank">Bukti {{ $i + 1 }}</a><br>
                        @endforeach
                    </td>
                     <td>
                        @if($item->nilai)
                            {{ $item->nilai }}
                        @else
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalNilai{{ $item->id }}">
                                Beri Nilai
                            </button>
                        @endif
                    </td>
                    <td>
                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $item->id }}">Edit</button>
                        <form action="{{ route('Pengabdian.delete', $item->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>

                <!-- Modal Edit -->
                <div class="modal fade" id="modalEdit{{ $item->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <form action="{{ route('Pengabdian.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Pengabdian</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <input name="judul_kegiatan" value="{{ $item->judul_kegiatan }}" class="form-control mb-2" placeholder="Judul Kegiatan">
                                    <input name="jenis_kegiatan" value="{{ $item->jenis_kegiatan }}" class="form-control mb-2" placeholder="Jenis Kegiatan">
                                    <input name="peran" value="{{ $item->peran }}" class="form-control mb-2" placeholder="Peran">
                                    <input name="lokasi" value="{{ $item->lokasi }}" class="form-control mb-2" placeholder="Lokasi">
                                    <input name="tahun_kegiatan" value="{{ $item->tahun_kegiatan }}" class="form-control mb-2" placeholder="Tahun">
                                    <input name="sumber_dana" value="{{ $item->sumber_dana }}" class="form-control mb-2" placeholder="Sumber Dana">
                                    <input name="jumlah_dana" value="{{ $item->jumlah_dana }}" class="form-control mb-2" placeholder="Jumlah Dana">
                                    <input name="output[]" type="file" class="form-control mb-2" multiple>
                                    <input name="file_bukti[]" type="file" class="form-control mb-2" multiple>
                                </div>
                                    <input name="nilai" value="{{ $item->nilai }}" class="form-control mb-2" placeholder="Nilai">
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


<!-- Modal Nilai -->
<div class="modal fade" id="modalNilai{{ $item->id }}" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('Pengabdian.nilai', $item->id) }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Beri Nilai Penelitian</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label for="penilaian" class="form-label">Nilai (1–10):</label>
                    <input type="number" name="nilai" class="form-control" min="1" max="10" required>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success">Simpan Nilai</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
