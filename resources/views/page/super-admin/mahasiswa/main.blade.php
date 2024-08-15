@extends('template.index')

@section('title')
<title>Daftar Mahasiswa</title>
@endsection

@section('content')
<div class="container-fluid p-0">
    <h1 class="h3 mb-3"><strong>Daftar Mahasiswa</strong></h1>

    <!-- Tombol Tambah Mahasiswa -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <form class="search-form" onsubmit="return false;">
            <input id="search-input" class="form-control form-control-sm me-2" type="search" placeholder="Cari"
                aria-label="Search"
                oninput="searchFunction('{{ route('mahasiswa.index') }}', '#search-input', '#search-body')">
        </form>
        <button class="btn btn-primary btn-sm btn-add-role" data-url="{{ route('mahasiswa.import') }}"
            data-method="POST">
            <i class="align-middle" data-feather="plus"></i> Tambah Mahasiswa
        </button>
    </div>

    <!-- Tabel Mahasiswa -->
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama</th>
                    <th scope="col">NIM</th>
                    <th scope="col">Prodi</th>
                    <th scope="col">Angkatan</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody id="search-body">
                @include('page.super-admin.mahasiswa.list', ['mahasiswa' => $mahasiswa])
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center">
        {{ $mahasiswa->links() }}
    </div>

    <div id="modalTemplate" style="display: none;">
        <form id="addRoleForm" method="POST" action="{{ route('mahasiswa.import') }}" enctype="multipart/form-data"
            class="formName">
            @csrf
            <div class="form-group">
                <label>Upload File Template</label>
                <input type="file" name="file" class="form-control" required>
                <a href="{{ asset('Template_Mahasiswa.xlsx') }}" class="btn btn-link">Download Template</a>
            </div>
        </form>
    </div>

</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.btn-add-role').forEach(function (button) {
            button.addEventListener('click', function () { 
                var content = document.getElementById('modalTemplate').innerHTML;
                var url = this.getAttribute('data-url');
                var method = this.getAttribute('data-method'); 
                modal_upload(content, url, method);
            });
        }); 
    }); 
</script>
@endsection

@section('css') 

@endsection