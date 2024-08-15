@extends('template.index')

@section('title')
<title>Daftar Kantin</title>
@endsection

@section('content')
<div class="container-fluid p-0">
    <h1 class="h3 mb-3"><strong>Daftar Kantin</strong></h1>

    <!-- Tombol Tambah Kantin -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <form class="search-form" onsubmit="return false;">
            <input id="search-input" class="form-control form-control-sm me-2" type="search" placeholder="Cari"
                aria-label="Search"
                oninput="searchFunction('{{ route('kantin.index') }}', '#search-input', '#kantin-body')">
        </form>
        @if (in_array('SuperAdmin', array_map(function($role) { return trim($role, '[]"'); }, (array)
        json_decode(Auth::user()->role, true))))
        @elseif(in_array('Mahasiswa', array_map(function($role) { return trim($role, '[]"'); }, (array)
        json_decode(Auth::user()->role, true))))
        @else
        <a class="btn btn-primary btn-sm" href="{{ route('kantin.create') }}">
            <i class="align-middle" data-feather="plus"></i> Tambah Kantin
        </a>
        @endif
    </div>

    <div class="row" id="kantin-body">
        @include('page.kantin.kantin.list', ['kantins' => $kantins, 'dataJadwalPic' => $dataJadwalPic])
    </div>
</div>
@endsection