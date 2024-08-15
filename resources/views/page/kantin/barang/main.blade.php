@extends('template.index')

@section('title')
<title>Data Barang</title>
@endsection

@section('content')
<div class="container-fluid p-0">
    <h1 class="h3 mb-3"><strong>Pemasukan Dan Pengeluaran Barang</strong></h1>

    <!-- Tombol Tambah Barang -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <form class="search-form" onsubmit="return false;">
            <input id="search-input" class="form-control form-control-sm me-2" type="search" placeholder="Cari"
                aria-label="Search"
                oninput="searchFunction('{{ route('barang.index') }}', '#search-input', '#barang-body')">
        </form>
        @if (in_array('SuperAdmin', array_map(function($role) { return trim($role, '[]"'); }, (array)
        json_decode(Auth::user()->role, true))))
        @else
        <a class="btn btn-primary btn-sm" href="{{ route('barang.create') }}">
            <i class="align-middle" data-feather="plus"></i> Tambah Barang
        </a>
        @endif
    </div>

    <!-- Tabel Barang -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Nama Barang</th>
                <th scope="col">Deskripsi Barang</th>
                <th scope="col">Stok</th>
                <th scope="col">Satuan</th>
                @if (in_array('SuperAdmin', array_map(function($role) { return trim($role, '[]"'); }, (array)
                json_decode(Auth::user()->role, true))))
                @else
                <th scope="col">Aksi</th>
                @endif
            </tr>
        </thead>
        <tbody id="barang-body">
            @include('page.kantin.barang.list', ['barang' => $barang])
        </tbody>
    </table>

</div>
@endsection