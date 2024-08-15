@extends('template.index')

@section('title')
<title>Tambah PIC Kantin</title>
@endsection

@section('content')
<div class="container-fluid p-0">
    <h1 class="h3 mb-3"><strong>Tambah PIC Kantin {{ $kantin->nama_kantin }}</strong></h1>

    <form id="formId">
        <div class="mb-3">
            <label for="user_id" class="form-label">Pilih PIC</label>
            <select class="form-control" id="user_id" name="user_id">
                <option value="">Pilih PIC</option>
                @foreach($asrama as $user)
                <option value="{{ $user->user_id }}"> {{ $user->username }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="pemilihan_tanggal" class="form-label">Tanggal</label>
            <input type="date" class="form-control" id="pemilihan_tanggal" name="pemilihan_tanggal">
        </div>
        <button type="submit" class="btn btn-primary" id="submitButton"
            onclick="save_data('#formId', '#submitButton', '{{ route('asrama.store', $kantin->id) }}', 'POST');">Tambah
            PIC</button>
    </form>
</div>
@endsection