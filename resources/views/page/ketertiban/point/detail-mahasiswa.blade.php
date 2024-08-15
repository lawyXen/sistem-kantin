@extends('template.index')

@section('title')
<title>Point Pelanggaran {{ $mahasiswa->nama }}</title>
@endsection

@section('content')
<div class="container-fluid p-0">
    <h1 class="h3 mb-3"><strong>Point Pelanggaran : {{ $mahasiswa->nama }}</strong></h1>

    <div class="card mb-4">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="akumulasi_skore" class="form-label">Akumulasi Skore</label>
                    <input type="text" class="form-control" id="akumulasi_skore" value="{{ $akumulasiSkore }}" readonly>
                </div>
                <div class="col-md-6">
                    <label for="nilai_huruf_point" class="form-label">Nilai Huruf Point</label>
                    <input type="text" class="form-control" id="nilai_huruf_point" value="{{ $nilaiHurufPoint }}"
                        readonly>
                </div>
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <a class="btn btn-primary w-100" href="{{ route('point.create', $mahasiswa->id) }}">Tambah
                    Pelanggaran</a>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Daftar Pelanggaran</h5>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Waktu Makan</th>
                            <th>Unit</th>
                            <th>Point</th>
                            <th>Tindakan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($points as $point)
                        <tr>
                            <td>{{ $point->tanggal }}</td>
                            <td>{{ $point->waktu_makan }}</td>
                            <td>
                                @if($point->user)
                                @php
                                $roles = json_decode($point->user->role, true);
                                $filteredRoles = array_filter($roles, function($role) {
                                return in_array($role, ['Ketertiban', 'Asrama']);
                                });
                                echo implode(', ', $filteredRoles);
                                @endphp
                                @else
                                User not found
                                @endif
                            </td>
                            <td>{{ $point->points }}</td>
                            <td>{{ $point->keterangan }}</td>
                            <td>
                                <a href="{{ route('point.edit', [$mahasiswa->id, $point->id]) }}"
                                    class="btn btn-warning btn-sm">Ubah</a>
                                <button class="btn btn-danger btn-sm"
                                    onclick="handle_delete('{{ route('point.delete', [$mahasiswa->id, $point->id]) }}')">Hapus</button>
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