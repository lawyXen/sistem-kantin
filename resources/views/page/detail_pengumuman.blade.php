@extends('template.index')

@section('title')
<title>Detail Pengumuman</title>
@endsection

@section('content')
<div class="container-fluid p-0">
    <h1 class="h3 mb-3"><strong>Detail Pengumuman</strong></h1>

    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Pengumuman: {{ $pengumuman->topik_pengumuman }}</h5>
        </div>
        <div class="card-body">
            <p><strong>Tanggal:</strong> {{ $pengumuman->tanggal_pengumuman }}</p>
            <p><strong>Dibuat Oleh:</strong> {{ $pengumuman->user->username }}</p>
            <p><strong>Deskripsi:</strong> <br>{!! $pengumuman->deskripsi !!}</p>
        </div>
        <div class="card-footer">
            <a href="{{ route('dashboard') }}" class="btn btn-secondary">Kembali ke Daftar</a>
        </div>
    </div>
</div>
@endsection