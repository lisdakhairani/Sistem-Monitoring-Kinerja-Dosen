@extends('layouts.admin_template')
@section('title', 'Profil')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Forms /</span> Profil</h4>
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header">Profil</h5>
                    <div class="card-body">
                        <div class="mb-4">
                            @include('profile.partials.update-profile-information-form')
                        </div>
                        <div class="mb-3 mt-5">
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
