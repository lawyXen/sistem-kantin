@extends('template.index')

@section('title')
<title>Detail Kantin</title>
@endsection

@section('content')
<div class="container-fluid p-0">
    <h1 class="h3 mb-3"><strong>Daftar Meja {{ $kantin->nama_kantin }}</strong></h1>

    <div class="row">
        <div class="col-6">
            <div class="card">
                <img class="card-img-top mx-auto d-block" src="{{ asset('storage/' . $kantin->gambar_kantin) }}"
                    alt="{{ $kantin->nama_kantin }}" style="max-height: 300px; object-fit: cover;"
                    onclick="showImageModal('{{ asset('storage/' . $kantin->gambar_kantin) }}')">
            </div>
        </div>
        <div class="col-6">
            <div class="card">
                <img class="card-img-top mx-auto d-block" src="{{ asset('storage/' . $kantin->gambar_denah) }}"
                    alt="{{ $kantin->nama_kantin }}" style="max-height: 300px; object-fit: cover;"
                    onclick="showImageModal('{{ asset('storage/' . $kantin->gambar_denah) }}')">
            </div>
        </div>
    </div>

    <!-- Tombol Tambah Barang -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <form class="search-form" onsubmit="return false;">
            <input id="search-input" class="form-control form-control-sm me-2" type="search" placeholder="Cari"
                aria-label="Search"
                oninput="searchFunction('{{ route('ketertiban.list_meja', $kantin->id) }}', '#search-input', '#meja-body')">
        </form>
        <div class="dropdown">
            <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="align-middle" data-feather="settings"></i> Pengaturan Kantin
            </button>
            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="{{ route('ketertiban.index', $kantin->id) }}">
                    <i class="align-middle me-2" data-feather="list"></i> Daftar Mahasiswa
                </a>
                <a class="dropdown-item" href="{{ route('ketertiban.create_meja', $kantin->id) }}">
                    <i class="align-middle me-2" data-feather="plus"></i> Tambah Meja
                </a>
            </div>
        </div>
    </div>

    <!-- Tabel Barang -->
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama Meja</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody id="meja-body">
                @include('page.ketertiban.detail-kantin.meja.list', ['mejaMakans' => $mejaMakans, 'kantin' => $kantin])
            </tbody>
        </table>
    </div>


</div>

<div class="d-flex justify-content-center">
    {{ $mejaMakans->links() }}
</div>

<div id="customModal" class="custom-modal">
    <span class="close" onclick="closeImageModal()">&times;</span>
    <img class="custom-modal-content" id="modalImage">
    <div id="caption"></div>
</div>
@endsection