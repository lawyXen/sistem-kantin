@extends('template.index')

@section('title')
<title>Daftar Piket</title>
@endsection

@section('content')
<div class="container-fluid p-0 d-flex justify-content-between align-items-center">
    <h1 class="h3 mb-3"><strong>Daftar Piket {{ $kantin->nama_kantin }}</strong></h1>
    <div class="d-flex justify-content-between align-items-center">
        <a class="btn btn-secondary btn-sm m-2" href="{{ route('ketertiban.index', $kantin->id) }}">
            <i class="align-middle"></i>Kembali ke {{ $kantin->nama_kantin }}
        </a>
        <div class="dropdown">
            <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="align-middle" data-feather="settings"></i> Piket
            </button>
            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="#" onclick="openEditModals('{{ $kantin->id }}')">
                    <i class="align-middle me-2" data-feather="list"></i> Tambah Jadwal Piket
                </a>
                <a class="dropdown-item" href="#" onclick="openTambahMahasiswa('{{ $kantin->id }}')">
                    <i class="align-middle me-2" data-feather="user-plus"></i> Tambah Mahasiswa Piket
                </a>
            </div>
        </div>
    </div>
</div>

<p class="mt-3"><strong>Kelompok yang Bertugas Hari Ini:</strong>
    @if($activePiket)
    <span class="badge bg-info">{{ $activePiket->nama_piket }}</span>
    @else
    <span class="badge bg-secondary">Tidak ada piket yang aktif</span>
    @endif
</p>
<div class="d-flex justify-content-between align-items-center mb-3">
    <a class="btn btn-primary btn-sm" onclick="openJadwalModal('{{ $kantin->id }}')">
        <i class="align-middle" data-feather="edit"></i> Ganti Kelompok Piket
    </a>
</div>

<div class="row">
    @foreach($piket as $p)
    <div class="col-md-4">
        <div class="card mb-4 shadow-sm {{ $activePiket && $p->id == $activePiket->id ? 'bg-active' : '' }}">
            <div class="card-header bg-primary ">
                <div class="d-flex justify-content-between">
                    <h5 class="card-title mb-0 text-white">{{ $p->nama_piket }}</h5>
                    <button class="btn btn-sm btn-danger"
                        onclick="handle_delete('{{ route('ketertiban.delete_jadwal', [$kantin->id, $p->id]) }}')">Hapus</button>
                </div>
            </div>
            <div class="card-body">
                <ul class="list">
                    @foreach($p->detailPikets as $detail)
                    <li class="mb-2 d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-person-fill me-1"></i>{{ $detail->mahasiswa->nama }}</span>
                        <div class="justify-content-between">
                            <button class="btn btn-sm btn-warning"
                                onclick="openEditMahasiswaModal('{{ $detail->id }}', '{{ $detail->mahasiswa->nama }}')">Ubah</button>
                            <button class="btn btn-sm btn-danger"
                                onclick="handle_delete('{{ route('ketertiban.delete_mahasiswa', ['kantin' => $kantin->id, 'id' => $detail->id]) }}')">Hapus</button>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endforeach
</div>

@include('page.ketertiban.piket.modal-tambah-piket')
@include('page.ketertiban.piket.modal-edit-jadwal')
@include('page.ketertiban.piket.modal-mahasiswa')
@include('page.ketertiban.piket.modal-edit-mahasiswa')

@endsection

@section('css')
<style>
    .bg-active {
        background: rgba(59, 125, 221, .25);
    }
</style>
@endsection