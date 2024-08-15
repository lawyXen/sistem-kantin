@extends('template.index')

@section('title')
<title>Daftar PIC Kantin</title>
@endsection

@section('content')
<div class="container-fluid p-0">
    <h1 class="h3 mb-3"><strong>Daftar PIC Kantin {{ $kantin->nama_kantin }}</strong></h1>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <form class="search-form" onsubmit="return false;">
            <input id="search-input" class="form-control form-control-sm me-2" type="search" placeholder="Cari"
                aria-label="Search"
                oninput="searchFunction('{{ route('asrama.index', $kantin->id) }}', '#search-input', '#asrama-body')">
        </form>
        <div class="justify-content-between">
            <a class="btn btn-info btn-sm" href="{{ route('kantin.index') }}">
                <i class="align-middle"></i> Kembali
            </a>
            <a class="btn btn-primary btn-sm" href="{{ route('asrama.create', $kantin->id) }}">
                <i class="align-middle" data-feather="plus"></i> Tambah PIC
            </a>
        </div>
    </div>

    <div class="row" id="asrama-body">
        @include('page.asrama.list', ['kantin' => $kantin])
    </div>


</div>
@endsection