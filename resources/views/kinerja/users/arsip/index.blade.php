@extends('layouts.admin_template')
@section('title', 'Arsip Kinerja Dosen')

@section('content')
<div class="container py-4">
    <h3 class="mb-4">Arsip <span style="color: #008374">Kinerja Dosen</span></h3>

    <!-- Form Filter -->
    <form method="GET" action="{{ route('kinerja.index') }}" class="mb-3">
        <div class="row">
            <div class="col-md-3 mb-2">
                <label class="form-label">Dosen</label>
                <select name="dosen_id" class="form-select">

                    @foreach($dosens as $dosen)
                        <option value="{{ $dosen->id }}" {{ request('dosen_id') == $dosen->id ? 'selected' : '' }}>
                            {{ $dosen->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 mb-2">
                <label class="form-label">Semester</label>
                <select name="semester_id" class="form-select">
                    <option value="">Semua Semester</option>
                    @foreach($semesters as $semester)
                        <option value="{{ $semester->id }}" {{ request('semester_id') == $semester->id ? 'selected' : '' }}>
                            {{ $semester->nama_semester }} {{ $semester->tahun_ajaran }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 mb-2">
                <label class="form-label">Tahun</label>
                <select name="tahun" class="form-select">
                    <option value="">Semua Tahun</option>
                    @for($i = date('Y'); $i >= date('Y') - 5; $i--)
                        <option value="{{ $i }}" {{ request('tahun') == $i ? 'selected' : '' }}>
                            {{ $i }}
                        </option>
                    @endfor
                </select>
            </div>
            <div class="col-md-3 d-flex align-items-end mb-2">
                <button type="submit" class="btn btn-primary me-2">Filter</button>
                <a href="{{ route('kinerja.index') }}" class="btn btn-secondary">Reset</a>
            </div>
        </div>
    </form>

    <!-- Tab Navigation -->
    <ul class="nav nav-tabs" id="kinerjaTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="menunggu-tab" data-bs-toggle="tab" data-bs-target="#menunggu" type="button" role="tab">
                Menunggu <span class="badge bg-secondary">{{ count($menunggu) }}</span>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="sedang-dinilai-tab" data-bs-toggle="tab" data-bs-target="#sedang-dinilai" type="button" role="tab">
                Sedang Dinilai <span class="badge bg-warning">{{ count($sedangDinilai) }}</span>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="selesai-tab" data-bs-toggle="tab" data-bs-target="#selesai" type="button" role="tab">
                Selesai <span class="badge bg-success">{{ count($selesai) }}</span>
            </button>
        </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content" id="kinerjaTabContent">
        <!-- Menunggu Tab -->
        <div class="tab-pane fade show active" id="menunggu" role="tabpanel">
            <div class="table-responsive mt-3">
                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Dosen</th>
                            <th>NIP/NIDN</th>
                            <th>Semester</th>
                            <th>Tanggal Pengisian</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($menunggu as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->dosen->name }}</td>
                            <td>{{ $item->dosen->nip ??  '-' }} / {{  $item->dosen->nidn ?? '-' }}</td>
                            <td>{{ $item->semester->nama_semester }} {{ $item->semester->tahun_ajaran }}</td>
                            <td>{{ $item->tanggal_pengisian->format('d/m/Y') }}</td>
                            <td>
                                <a href="{{ route('kinerja.show', $item->id) }}" class="btn btn-warning btn-sm">
                                    <i class="bi bi-eye"></i> Lihat
                                </a>

                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="text-center">Tidak ada data</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Sedang Dinilai Tab -->
        <div class="tab-pane fade" id="sedang-dinilai" role="tabpanel">
            <div class="table-responsive mt-3">
                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Dosen</th>
                            <th>NIP/NIDN</th>
                            <th>Semester</th>
                            <th>Tanggal Pengisian</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sedangDinilai as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->dosen->name }}</td>
                            <td>{{ $item->dosen->nip ??  '-' }} / {{  $item->dosen->nidn ?? '-' }}</td>
                            <td>{{ $item->semester->nama_semester }} {{ $item->semester->tahun_ajaran }}</td>
                            <td>{{ $item->tanggal_pengisian->format('d/m/Y') }}</td>
                            <td>
                                <a href="{{ route('arsip.show', $item->id) }}" class="btn btn-warning btn-sm">
                                    <i class="bi bi-eye"></i> Lihat
                                </a>

                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="text-center">Tidak ada data</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Selesai Tab -->
        <div class="tab-pane fade" id="selesai" role="tabpanel">
            <div class="table-responsive mt-3">
                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Dosen</th>
                            <th>NIP/NIDN</th>
                            <th>Semester</th>
                            <th>Tanggal Pengisian</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($selesai as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->dosen->name }}</td>
                            <td>{{ $item->dosen->nip ??  '-' }} / {{  $item->dosen->nidn ?? '-' }}</td>
                            <td>{{ $item->semester->nama_semester }} {{ $item->semester->tahun_ajaran }}</td>
                            <td>{{ $item->tanggal_pengisian->format('d/m/Y') }}</td>
                            <td>
                                <a href="{{ route('kinerja.show', $item->id) }}" class="btn btn-warning btn-sm">
                                    <i class="bi bi-eye"></i> Lihat
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="text-center">Tidak ada data</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .pagination {
        flex-wrap: wrap;
        font-size: 12pt;
    }
    .pagination .page-item .page-link {
        color: #008374;
    }
    .pagination .page-item.active .page-link {
        background-color: #008374;
        border-color: #008374;
        color: white;
    }
    .pagination .page-item.disabled .page-link {
        color: #6c757d;
    }
    .nav-tabs .nav-link.active {
        color: #008374;
        font-weight: bold;
    }
</style>
@endsection
