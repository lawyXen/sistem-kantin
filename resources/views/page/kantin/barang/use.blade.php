@extends('template.index')

@section('title')
<title>Gunakan Barang</title>
@endsection

@section('content')
<div class="container-fluid p-0">
    <h1 class="h3 mb-3"><strong>Gunakan Barang: {{ $barang->name }} </strong></h1>

    <div class="container mt-3">
        <form id="formId">
            <div class="row">
                <div class="col-6">
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Jumlah Pakai</label>
                        <input type="number" class="form-control" id="quantity" name="quantity"
                            placeholder="{{ $barang->stock }}">
                    </div>
                    <div class="mb-3">
                        <label for="date" class="form-label">Tanggal Pemakaian</label>
                        <input type="date" class="form-control" id="date" name="date">
                    </div>
                </div>
                <div class="col-6">
                    <div class="mb-3">
                        <label for="date" class="form-label">Status</label>
                        <select name="status" class="form-control" id="status">
                            <option value="">Plih Status</option>
                            <option value="Masuk">Barang Masuk</option>
                            <option value="Keluar">Barang Keluar</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="satuan" class="form-label">Satuan</label>
                        <input type="text" class="form-control" id="satuan" name="satuan" value="{{ $barang->satuan }}"
                            readonly placeholder="{{ $barang->satuan }}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="mb-3">
                    <label for="detail" class="form-label">Deskripsi</label>
                    <textarea class="form-control" id="detail" name="detail" rows="10"></textarea>
                </div>
            </div>
            <button type="button" class="btn btn-secondary"
                onclick="cancelForm('{{ route('barang.show', $barang->id) }}')">Batal</button>
            <button type="submit" class="btn btn-primary" id="submitButton"
                onclick="save_data('#formId', '#submitButton', '{{ route('barang.using', $barang->id) }}', 'POST');">Gunakan
                Barang</button>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    var textarea = document.getElementById('detail');
    sceditor.create(textarea, {
        format: 'xhtml', 
        style: '{{ asset('editor/minified/themes/content/default.min.css') }}'
    }); 
</script>
@endsection