@extends('template.index')

@section('title')
<title>Pengumuman</title>
@endsection

@section('content')
<div class="container-fluid p-0">
    <h1 class="h3 mb-3"><strong>Pengumuman</strong></h1>

    <!-- Tombol Tambah Pengumuman -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <form class="search-form" onsubmit="return false;">
            <input id="search-input" class="form-control form-control-sm me-2" type="search" placeholder="Cari"
                aria-label="Search"
                oninput="searchFunction('{{ route('pengumuman.index') }}', '#search-input', '#pengumuman-body')">
        </form>
        <a class="btn btn-primary btn-sm" href="{{ route('pengumuman.create') }}">
            <i class="align-middle" data-feather="plus"></i> Tambah Pengumuman
        </a>
    </div>

    <!-- Tabel Pengumuman -->
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Tanggal</th>
                    <th scope="col">Topik Pengumuman</th>
                    <th scope="col">Dibuat Oleh</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody id="pengumuman-body">
                @include('page.kantin.pengumuman.list', ['pengumuman' => $pengumuman])
            </tbody>
        </table>
    </div>
</div>
@endsection