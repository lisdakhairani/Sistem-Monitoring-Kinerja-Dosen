@extends('welcome')

@section('title', 'Download Akademik')
@section('content')

<div class="container">
    <div class="row d-flex justify-content-center">
        <div class="col-md-10 my-3">
            <h2 class="mt-3">
                Download Dokumen <br><span style="color: #008374">Program Magister Ilmu Manajemen</span>
            </h2>
            <br>
            <div class="table-responsive">
                <table class="table table-hover mt-2">
                    <thead>
                        <tr>
                            <th scope="col">Nama Documen</th>
                            <th scope="col">Download File</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ( $downloadakademik as $item)
                        <tr>
                            <td>
                                <article>
                                    {!! $item->body !!}
                                </article>
                            </td>
                            <td>
                                <a href="{{ asset('storage/' . $item->filedata) }}" download="{{ $item->body }}"><i
                                        class="bi bi-arrow-down-circle-fill"></i> Download</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

@endsection
