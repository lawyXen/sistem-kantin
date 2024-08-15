@extends('template.index')

@section('title')
<title>Menu Makanan</title>
@endsection

@section('content')
<div class="container-fluid p-0">
    <h1 class="h3 mb-3"><strong>Daftar Menu Kantin</strong></h1>
</div>

<!-- Tombol Tambah Hari -->
<div class="d-flex justify-content-between align-items-center mb-4"><br>
    @if (in_array('SuperAdmin', array_map(function($role) { return trim($role, '[]"'); }, (array)
    json_decode(Auth::user()->role, true))))
    @elseif(in_array('Mahasiswa', array_map(function($role) { return trim($role, '[]"'); }, (array)
    json_decode(Auth::user()->role, true))))
    @else
    <a class="btn btn-primary btn-sm" href="{{ route('menu.create') }}">
        <i class="align-middle" data-feather="plus"></i> Tambah Menu
    </a>
    @endif
</div>

<!-- Tabel Menu Kantin -->
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Hari/Tanggal</th>
                <th>Menu Makan Pagi</th>
                <th>Status Makan Pagi</th>
                <th>Menu Makan Siang</th>
                <th>Status Makan Siang</th>
                <th>Menu Makan Malam</th>
                <th>Status Makan Malam</th>
                @if(in_array('Mahasiswa', array_map(function($role) { return trim($role, '[]"'); }, (array)
                json_decode(Auth::user()->role, true))))
                @else
                <th>Aksi</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @if($menu->isEmpty())
            <tr>
                <td colspan="8" class="text-center">Tidak ada menu yang tersedia untuk minggu ini dan minggu depan.</td>
            </tr>
            @else
            @foreach($menu as $item)
            <tr>
                <td>{{ \Carbon\Carbon::parse($item->created_at)->format('l, j F Y') }}</td>
                <td>{!! ($item->menu_sarapan) !!}</td>
                <td>{!! ($item->status_sarapan) !!}</td>
                <td>{!! ($item->menu_siang) !!}</td>
                <td>{!! ($item->status_siang) !!}</td>
                <td>{!! ($item->menu_malam) !!}</td>
                <td>{!! ($item->status_malam) !!}</td>
                @if(in_array('Mahasiswa', array_map(function($role) { return trim($role, '[]"'); }, (array)
                json_decode(Auth::user()->role, true))))
                @else
                <td>
                    <a class="btn btn-warning btn-sm" href="{{ route('menu.edit', $item->id) }}">
                        <i class="align-middle" data-feather="edit"></i> Ubah
                    </a>
                    <a class="btn btn-danger btn-sm" onclick="handle_delete('{{ route('menu.destroy', $item->id) }}');">
                        <i class="align-middle" data-feather="trash"></i> Hapus
                    </a>
                </td>
                @endif
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>
</div>
@endsection