@extends('template.index')

@section('title')
<title>Detail Barang</title>
@endsection

@section('content')
<div class="container-fluid p-0">
    <h1 class="h3 mb-3"><strong>Riwayat Pemakaian : {{ $barang->name }} </strong></h1>
    <p class="h5 mb-3"><strong>Stok Tersedia : {{ $barang->stock }} {{ $barang->satuan }}</strong></p>

    <div class="container mt-3">
        <div class="justify-content-end mb-3 text-end">
            <a onclick="cancelForm('{{ route('barang.index') }}')" class="btn btn-secondary">Kembali</a>
            @if (in_array('SuperAdmin', array_map(function($role) { return trim($role, '[]"'); }, (array)
            json_decode(Auth::user()->role, true))))
            @else
            <a href="{{ route('barang.use', $barang->id) }}" class="btn btn-primary">Gunakan Barang</a>
            @endif
        </div>
        <h2>Riwayat Pemakaian</h2>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Tanggal Pemakaian</th>
                        <th>Status</th>
                        <th>Dipakai</th>
                        <th>Stock Sebelumnya</th>
                        <th>satuan</th>
                        <th>Deskripsi</th>
                        <th>Dibuat Oleh</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($detail as $item)
                    <tr>
                        <td>{{ $item->date }}</td>
                        <td>
                            @if($item->status == 'Masuk')
                            <p class="badge bg-primary">{{ $item->status }}</p>
                            @else
                            <p class="badge bg-info">{{ $item->status }}</p>
                            @endif
                        </td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->stock }}</td>
                        <td>{{ $item->satuan }}</td>
                        <td>{!! $item->detail !!}</td>
                        <td>{{ $item->user->username }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada data</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection