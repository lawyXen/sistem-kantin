@extends('template.index')

@section('title')
<title>{{ $meja->exists ? 'Edit Meja' : 'Tambah Meja' }}</title>
@endsection

@section('content')
<div class="container-fluid p-0">
    <h1 class="h3 mb-3"><strong>{{ $meja->exists ? 'Edit Meja' : 'Tambah Meja' }}</strong></h1>

    <form id="formMeja">

        <div class="mb-3">
            <label for="nama_meja" class="form-label">Nama Meja</label>
            <input type="text" class="form-control" id="nama_meja" name="nama_meja" value="{{ $meja->nama_meja }}">
        </div>

        <button type="submit" class="btn btn-primary" id="submitButton" onclick="save_data('#formMeja','#submitButton',
            '{{ $meja->exists ? route('ketertiban.update_meja', [$kantin->id, $meja->id]) : route('ketertiban.store_meja', $kantin->id) }}', 
            '{{ $meja->exists ? 'PUT' : 'POST' }}');">{{
            $meja->exists ? 'Simpan Perubahan' : 'Simpan' }}</button>
        <a href="{{ route('ketertiban.list_meja', $kantin->id) }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection