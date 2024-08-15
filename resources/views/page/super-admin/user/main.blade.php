@extends('template.index')

@section('title')
<title>Pengaturan Role</title>
@endsection

@section('content')
<div class="container-fluid p-0">
    <h1 class="h3 mb-3"><strong>Pengaturan Role</strong></h1>

    <!-- Tombol Tambah Pengumuman -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <form class="search-form" onsubmit="return false;">
            <input id="search-input" class="form-control form-control-sm me-2" type="search" placeholder="Cari"
                aria-label="Search"
                oninput="searchFunction('{{ route('user.index') }}', '#search-input', '#user-body')">
        </form>
        {{-- <a class="btn btn-primary btn-sm" href="{{ route('user.create') }}">
            <i class="align-middle" data-feather="plus"></i> Tambah Pengumuman
        </a> --}}
    </div>

    <!-- Tabel Pengumuman -->
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Username</th>
                    <th scope="col">Role</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody id="user-body">
                @include('page.super-admin.user.list', ['users' => $users])
            </tbody>
        </table>
    </div>

    <div id="addRoleFormTemplate" style="display: none;">
        <form id="addRoleForm" method="POST" action="{{ route('user.addRole') }}" class="formName">
            @csrf
            <input type="hidden" name="user_id" value="">
            <div class="form-group">
                <label>Pilih Role</label>
                <select class="form-select" id="new_role" name="new_role">
                    <option value="Staff">Staff</option>
                    <option value="Kantin">Kantin</option>
                    <option value="Asrama">Asrama</option>
                    <option value="Mahasiswa">Mahasiswa</option>
                    <option value="Ketertiban">Ketertiban</option>
                </select>
            </div>
        </form>
    </div>

    <div id="removeRoleFormTemplate" style="display: none;">
        <form id="removeRoleForm" method="POST" action="{{ route('user.removeRole') }}" class="formName">
            @csrf
            <input type="hidden" name="user_id" value="">
            <div class="form-group">
                <label>Pilih Role untuk Dihapus</label>
                <select class="form-select" id="remove_role" name="remove_role">
                    <!-- Options akan ditambahkan secara dinamis oleh JavaScript -->
                </select>
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
                var userId = this.getAttribute('data-user-id');
                var content = document.getElementById('addRoleFormTemplate').innerHTML;
                var url = this.getAttribute('data-url');
                var method = this.getAttribute('data-method'); // Assuming you have this attribute set
                handle_add_role(userId, content, url, method);
            });
        });

        document.querySelectorAll('.btn-remove-role').forEach(function (button) {
            button.addEventListener('click', function () {
                var userId = this.getAttribute('data-user-id');
                var roles = JSON.parse(this.getAttribute('data-roles')); // Parse roles array
                var content = document.getElementById('removeRoleFormTemplate').innerHTML;
                var url = this.getAttribute('data-url');
                var method = this.getAttribute('data-method');
                handle_remove_role(userId, roles, content, url, method);
            });
        });
    });

    
</script>
@endsection