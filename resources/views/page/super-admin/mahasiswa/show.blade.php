@extends('template.index')

@section('title')
<title>Data Diri Mahasiswa</title>
@endsection

@section('content')
<div class="container-fluid p-0">
    <h1 class="h3 mb-3"><strong>Data Diri Mahasiswa</strong></h1>

    <div class=" text-end mb-4">
        <button type="button" class="btn btn-secondary"
            onclick="cancelForm('{{ route('mahasiswa.index') }}')">Kembali</button>
    </div>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="frame">
                    <h2 class="data-diri-title">Data Diri</h2>
                    <div class="frame mt-3 data-diri-table">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td><strong>Nama</strong></td>
                                    <td>{{ $mahasiswa->nama }}</td>
                                </tr>
                                <tr>
                                    <td><strong>NIM</strong></td>
                                    <td>{{ $mahasiswa->nim }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Prodi</strong></td>
                                    <td>{{ $mahasiswa->prodi }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Angkatan</strong></td>
                                    <td>{{ $mahasiswa->angkatan }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Email</strong></td>
                                    <td>{{ $mahasiswa->email }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Username</strong></td>
                                    <td>{{ $mahasiswa->username }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection