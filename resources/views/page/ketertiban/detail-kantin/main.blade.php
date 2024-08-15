@php
$roles = json_decode(Auth::user()->role, true);
$roles = array_map(function($role) {
return trim($role, '[]"');
}, (array) $roles);

$hasMahasiswa = in_array('Mahasiswa', $roles);
$hasKetertiban = in_array('Ketertiban', $roles);
$shouldShowActionButtons = $hasKetertiban && $hasMahasiswa;
@endphp

@extends('template.index')

@section('title')
<title>Detail Kantin</title>
@endsection

@section('content')
<div class="container-fluid p-0">
    <h1 class="h3 mb-3"><strong>Detai Kantin {{ $kantin->nama_kantin }}</strong></h1>
    <div class="text-end">
        <button type="button" class="btn btn-secondary mb-3 "
            onclick="cancelForm('{{ route('kantin.index') }}')">Kembali</button>
    </div>

    <div class="row">
        <div class="col-12">
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
                oninput="searchFunction('{{ route('ketertiban.index', $kantin->id) }}', '#search-input', '#barang-body')">
        </form>
        @if ($shouldShowActionButtons)
        <div class="d-flex justify-content-between align-items-center">
            <a class="btn btn-primary btn-sm m-2" href="{{ route('ketertiban.piket_index', $kantin->id) }}">
                <i class="align-middle" data-feather="plus"></i> Daftar Piket
            </a>
            <div class="dropdown">
                <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="align-middle" data-feather="settings"></i> Pengaturan Kantin
                </button>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="{{ route('ketertiban.list_meja', $kantin->id) }}">
                        <i class="align-middle me-2" data-feather="list"></i> Daftar Meja
                    </a>
                    <a class="dropdown-item" href="{{ route('ketertiban.create', $kantin->id) }}">
                        <i class="align-middle me-2" data-feather="user-plus"></i> Tambah Mahasiswa
                    </a>
                </div>
            </div>
        </div>
        @endif

    </div>

    <!-- Tabel Barang -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Nama Mahasiswa</th>
                <th scope="col">Prodi</th>
                <th scope="col">Angkatan</th>
                <th scope="col">Nama Meja</th>
                @if ($shouldShowActionButtons)
                <th scope="col">Aksi</th>
                @endif
            </tr>
        </thead>
        <tbody id="barang-body">
            @include('page.ketertiban.detail-kantin.list', ['mahasiswa' => $mahasiswa])
        </tbody>
    </table>

</div>

<div class="d-flex justify-content-center">
    {{ $mahasiswa->links() }}
</div>

<div id="editModal" class="custom-modal">
    <div class="custom-modal-content">
        <div class="custom-modal-header">
            <h5 class="custom-modal-title" id="editModalLabel">Ubah Meja Makan</h5>
            <button type="button" class="custom-modal-close" onclick="closeModal()">&times;</button>
        </div>
        <div class="custom-modal-body">
            <form id="editForm">
                <input type="hidden" name="id" id="mahasiswaId">
                <div class="mb-3">
                    <label for="nama_mahasiswa" class="form-label">Nama Mahasiswa</label>
                    <input type="text" class="form-control" id="nama_mahasiswa" readonly>
                </div>
                <div class="mb-3">
                    <label for="meja_id" class="form-label">Meja Makan</label>
                    <select class="form-select" id="meja_id" name="meja_id" required>
                        <option selected disabled>Pilih meja makan...</option>
                        @foreach($mejaMakan as $meja)
                        <option value="{{ $meja->id }}">{{ $meja->nama_meja }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary" id="submitButton"
                    onclick="save_data('#editForm', '#submitButton', '{{ route('ketertiban.update', $kantin->id) }}', 'PUT');">Simpan</button>
            </form>
        </div>
    </div>
</div>


<div id="customModal" class="custom-modal">
    <span class="close" onclick="closeImageModal()">&times;</span>
    <img class="custom-modal-content" id="modalImage">
    <div id="caption"></div>
</div>
@endsection