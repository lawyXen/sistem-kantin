@extends('template.index')

@section('title')
<title>{{ isset($pengumuman) ? 'Edit Pengumuman' : 'Buat Pengumuman Baru' }}</title>
@endsection

@section('content')
<div class="container-fluid p-0">
    <h1 class="h3 mb-3"><strong>{{ isset($pengumuman) ? 'Edit Pengumuman' : 'Tambah Pengumuman' }}</strong></h1>

    <!-- Form tambah/edit pengumuman -->
    <form id="formPengumuman">
        <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal</label>
            <input type="date" class="form-control" id="tanggal" name="tanggal_pengumuman"
                value="{{ isset($pengumuman) ? $pengumuman->tanggal_pengumuman : '' }}">
        </div>
        <div class="mb-3">
            <label for="topik" class="form-label">Topik Pengumuman</label>
            <input type="text" class="form-control" id="topik" name="topik_pengumuman"
                value="{{ isset($pengumuman) ? $pengumuman->topik_pengumuman : '' }}"
                placeholder="Enter the announcement topic">
        </div>
        <div class="mb-3">
            <label for="role" class="form-label">Dibuat Oleh</label>
            <select class="form-select" id="role" name="user_id">
                <option value="{{ Auth::user()->user_id }}">{{ Auth::user()->username }}</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea class="form-control" id="deskripsi" name="deskripsi"
                rows="10">{{ isset($pengumuman) ? $pengumuman->deskripsi : '' }}</textarea>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary"
                onclick="cancelForm('{{ route('pengumuman.index') }}')">Batal</button>
            <button type="submit" class="btn btn-primary" id="submitButton" onclick="save_data('#formPengumuman', '#submitButton', 
                '{{ isset($pengumuman) ? route('pengumuman.update', $pengumuman->id) : route('pengumuman.store') }}', 
                '{{ isset($pengumuman) ? 'PUT' : 'POST' }}');">{{
                isset($pengumuman) ? 'Simpan Perubahan' : 'Simpan' }}</button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    var textarea = document.getElementById('deskripsi');
    sceditor.create(textarea, {
        format: 'xhtml', 
        style: '{{ asset('editor/minified/themes/content/default.min.css') }}'
    }); 
</script>

@endsection