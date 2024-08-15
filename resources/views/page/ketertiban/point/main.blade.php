@extends('template.index')

@section('title')
<title>Point Pelanggaran</title>
@endsection

@section('content')
<div class="container-fluid p-0">
    <h1 class="h3 mb-3"><strong>Point Pelanggaran</strong></h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('point.search') }}" method="GET">
                @csrf
                <div class="row">
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="nim" class="form-label">NIM</label>
                            <input type="text" class="form-control" id="nim" name="nim" value="{{ request('nim') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" value="{{ request('nama') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="prodi" class="form-label">Pilih Prodi</label>
                            <select class="form-select" id="prodi" name="prodi">
                                <option value="">Pilih Prodi</option>
                                @foreach($prodis as $prodi)
                                <option value="{{ $prodi }}" {{ request('prodi')==$prodi ? 'selected' : '' }}>{{ $prodi
                                    }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="angkatan" class="form-label">Pilih Angkatan</label>
                            <select class="form-select" id="angkatan" name="angkatan">
                                <option value="">Pilih Angkatan</option>
                                @foreach($angkatans as $angkatan)
                                <option value="{{ $angkatan }}" {{ request('angkatan')==$angkatan ? 'selected' : '' }}>
                                    {{ $angkatan }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Cari</button>
                <a href="{{ route('point.index') }}" class="btn btn-secondary">Clear</a>
            </form>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-body">
            <h5 class="card-title">Hasil Pencarian</h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>Prodi</th>
                        <th>Angkatan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                @if(isset($mahasiswas) && !$mahasiswas->isEmpty())
                @foreach($mahasiswas as $mahasiswa)
                <tr>
                    <td>{{ $mahasiswa->nim }}</td>
                    <td>{{ $mahasiswa->nama }}</td>
                    <td>{{ $mahasiswa->prodi }}</td>
                    <td>{{ $mahasiswa->angkatan }}</td>
                    <td>
                        <a class="btn btn-info btn-sm"
                            href="{{ route('point.detail', $mahasiswa->id) }}">Selengkapnya</a>
                    </td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="5" class="text-center">Tidak ada mahasiswa</td>
                </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection