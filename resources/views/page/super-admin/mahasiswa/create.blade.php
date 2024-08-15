@extends('template.index')

@section('title')
<title>Edit Data Diri Mahasiswa</title>
@endsection

@section('content')
<div class="container-fluid p-0">
    <h1 class="h3 mb-3"><strong>Edit Data Diri Mahasiswa</strong></h1>

    <div class=" text-end mb-4">
        <button type="button" class="btn btn-secondary"
            onclick="cancelForm('{{ route('mahasiswa.index') }}')">Kembali</button>
    </div>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="frame">
                    <h2 class="data-diri-title">Edit Data Diri</h2>
                    <div class="frame mt-3 data-diri-table">
                        <form id="formId">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <td><strong>Nama</strong></td>
                                        <td>
                                            <input type="text" name="nama" class="form-control"
                                                value="{{ $mahasiswa->nama }}" required>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>NIM</strong></td>
                                        <td>
                                            <input type="text" name="nim" class="form-control"
                                                value="{{ $mahasiswa->nim }}" required>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Prodi</strong></td>
                                        <td>
                                            <input type="text" name="prodi" class="form-control"
                                                value="{{ $mahasiswa->prodi }}" required>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Angkatan</strong></td>
                                        <td>
                                            <input type="text" name="angkatan" class="form-control"
                                                value="{{ $mahasiswa->angkatan }}" required>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Email</strong></td>
                                        <td>
                                            <input type="email" name="email" class="form-control"
                                                value="{{ $mahasiswa->email }}" required>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Username</strong></td>
                                        <td>
                                            <input type="text" name="username" class="form-control"
                                                value="{{ $mahasiswa->username }}" required>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary" id="submitButton"
                                    onclick="save_data('#formId', '#submitButton', '{{ route('mahasiswa.update', $mahasiswa->id) }}', 'PUT');">Simpan
                                    Perubahan</button>
                                <button type="button" class="btn btn-secondary"
                                    onclick="cancelForm('{{ route('mahasiswa.index') }}')">Batal</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection