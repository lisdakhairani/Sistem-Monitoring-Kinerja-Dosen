@extends('layouts.admin_template')
@section('title', 'Dashboard')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        {{-- Kartu Jumlah --}}
        <div class="col-md-3">
            <div class="card bg-primary text-white text-center">
                <div class="card-body">
                    <h5>Penelitian</h5>
                    <h2>{{ $jumlahPenelitian }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white text-center">
                <div class="card-body">
                    <h5>Pengajaran</h5>
                    <h2>{{ $jumlahPengajaran }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white text-center">
                <div class="card-body">
                    <h5>Pengabdian</h5>
                    <h2>{{ $jumlahPengabdian }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white text-center">
                <div class="card-body">
                    <h5>Penunjang</h5>
                    <h2>{{ $jumlahPenunjang }}</h2>
                </div>
            </div>
        </div>
@endsection


