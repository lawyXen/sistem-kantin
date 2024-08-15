@extends('template.index')

@section('title')
<title>{{ isset($barang) ? 'Edit Barang' : 'Buat Barang Baru' }}</title>
@endsection

@section('content')
<div class="container-fluid p-0">
    <h1 class="h3 mb-3"><strong>{{ isset($barang) ? 'Edit Barang Kantin' : 'Tambah Barang Kantin' }}</strong></h1>

    <!-- Form Tambah Barang -->
    <form id="formBarang">
        <div class="mb-3">
            <label for="name" class="form-label">Nama Barang</label>
            <input type="text" class="form-control" id="name" name="name"
                value="{{ isset($barang) ? $barang->name : '' }}">
        </div>
        <div class="mb-3">
            <label for="stock" class="form-label">Jumlah Barang</label>
            <input type="number" class="form-control" id="stock" name="stock"
                value="{{ isset($barang) ? $barang->stock : '' }}">
        </div>
        <div class="mb-3">
            <label for="satuan" class="form-label">Satuan Barang</label>
            <input type="text" class="form-control" id="satuan" name="satuan" placeholder="Kg"
                value="{{ isset($barang) ? $barang->satuan : '' }}">
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Deskripsi</label>
            <textarea class="form-control" id="description" name="description"
                rows="10">{{ isset($barang) ? $barang->description : '' }}</textarea>
        </div>
        <div class="mb-3">
            <button type="button" class="btn btn-secondary"
                onclick="cancelForm('{{ route('barang.index') }}')">Batal</button>
            <button type="submit" class="btn btn-primary" id="submitButton" onclick="save_data('#formBarang', '#submitButton', 
                    '{{ isset($barang) ? route('barang.update', $barang->id) : route('barang.store') }}', 
                    '{{ isset($barang) ? 'PUT' : 'POST' }}');">{{
                isset($barang) ? 'Simpan Perubahan' : 'Simpan' }}</button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    var textarea = document.getElementById('description');
    sceditor.create(textarea, {
        format: 'xhtml', 
        style: '{{ asset('editor/minified/themes/content/default.min.css') }}'
    }); 
</script>

@endsection