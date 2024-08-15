@php
// Decode role JSON and trim extra characters
$roles = json_decode(Auth::user()->role, true);
$roles = array_map(function($role) {
return trim($role, '[]"');
}, (array) $roles);

// Check if user has specific roles
$hasKetertiban = in_array('Ketertiban', $roles);
$hasAsrama = in_array('Asrama', $roles);
$hasMahasiswa = in_array('Mahasiswa', $roles);

// Determine if any of the roles that should show "Detail" are present
$shouldShowDetail = $hasKetertiban || $hasAsrama || $hasMahasiswa;
@endphp

@if($kantins->isEmpty())
<div class="col-12">
    <div class="alert alert-warning" role="alert">
        Tidak ada kantin yang ditemukan.
    </div>
</div>
@else
@foreach($kantins as $kantin)
<div class="col-12 col-md-6 mb-4" data-kantin-id="{{ $kantin->id }}">
    <div class="card">
        <img class="card-img-top mx-auto d-block" src="{{ asset('storage/' . $kantin->gambar_kantin) }}"
            alt="{{ $kantin->nama_kantin }}" style="max-height: 300px; object-fit: cover;">
        <div class="card-header">
            <h5 class="card-title mb-0">{{ $kantin->nama_kantin }}</h5>
        </div>
        <div class="card-body">
            <p>PIC hari ini:</p>
            @if(isset($dataJadwalPic[$kantin->id]) && !$dataJadwalPic[$kantin->id]->isEmpty())
            <ul>
                @foreach($dataJadwalPic[$kantin->id] as $pic)
                <li class="list-unstyled">{{ $pic->user->username }}</li>
                @endforeach
            </ul>
            @else
            <p>Tidak ada PIC yang bertugas hari ini</p>
            @endif
            <p class="card-text">{!! $kantin->deskripsi !!}</p>
            <div class="justify-content-end">
                @if ($hasKetertiban)
                <a href="{{ route('kantin.edit', $kantin->id) }}" class="btn btn-warning">Edit</a>
                <button type="submit" onclick="handle_delete('{{ route('kantin.destroy', $kantin->id) }}');"
                    class="btn btn-danger">Hapus</button>
                @endif

                @if ($shouldShowDetail)
                <a href="{{ route('ketertiban.index', $kantin->id) }}" class="btn btn-primary">Detail</a>
                @endif

                @if ($hasAsrama)
                <a href="{{ route('asrama.index', $kantin->id) }}" class="btn btn-info">Kelola PIC</a>
                @endif
            </div>
        </div>
    </div>
</div>
@endforeach
@endif