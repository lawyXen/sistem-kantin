@extends('template.index')

@section('title')
<title>{{ isset($kantin) ? 'Edit Kantin' : 'Buat Kantin Baru' }}</title>
@endsection

@section('content')
<div class="container-fluid p-0">
    <h1 class="h3 mb-3"><strong>{{ isset($kantin) ? 'Edit Kantin' : 'Tambah Kantin' }}</strong></h1>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form id="formKantin">
                        <div class="mb-3 col-12">
                            <label for="namaKantin" class="form-label">Nama Kantin</label>
                            <input type="text" class="form-control" id="namaKantin" name="nama_kantin"
                                value="{{ isset($kantin) ? $kantin->nama_kantin : '' }}">
                        </div>
                        <div class="row">
                            <div class="mb-3 col-6">
                                <label for="gambarKantin" class="form-label">Upload Gambar Kantin</label>
                                <input type="file" class="form-control" id="gambarKantin" name="gambar_kantin"
                                    accept="image/*" onchange="previewImage(event, '#previewGambarKantin')">
                                @if(isset($kantin) && $kantin->gambar_kantin)
                                <img id="previewGambarKantin" src="{{ asset('storage/' . $kantin->gambar_kantin) }}"
                                    alt="Gambar Kantin" class="mt-2" height="200">
                                @else
                                <img id="previewGambarKantin" src="#" alt="Gambar Kantin" class="mt-2 d-none"
                                    height="200">
                                @endif
                            </div>
                            <div class="mb-3 col-6">
                                <label for="denahKantin" class="form-label">Upload Denah Kantin</label>
                                <input type="file" class="form-control" id="denahKantin" name="gambar_denah"
                                    accept="image/*" onchange="previewImage(event, '#previewDenahKantin')">
                                @if(isset($kantin) && $kantin->gambar_denah)
                                <img id="previewDenahKantin" src="{{ asset('storage/' . $kantin->gambar_denah) }}"
                                    alt="Denah Kantin" class="mt-2" height="200">
                                @else
                                <img id="previewDenahKantin" src="#" alt="Denah Kantin" class="mt-2 d-none"
                                    height="200">
                                @endif
                            </div>
                        </div>
                        <div class="mb-3 col-12">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi"
                                rows="10">{{ isset($kantin) ? $kantin->deskripsi : '' }}</textarea>
                        </div>
                        <div class="justify-content-start">
                            <a type="button" class="btn btn-secondary"
                                onclick="cancelForm('{{ route('kantin.index') }}')">Batal</a>
                            <button type="submit" class="btn btn-primary" id="submitButton" onclick="save_data('#formKantin', '#submitButton', 
                            '{{ isset($kantin) ? route('kantin.update', $kantin->id) : route('kantin.store') }}', 
                            '{{ isset($kantin) ? 'PUT' : 'POST' }}');">{{ isset($kantin) ? 'Simpan Perubahan' :
                                'Tambah' }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
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