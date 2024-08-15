@extends('template.index')

@section('title')
<title>Dashboard</title>
@endsection

@section('content')
@if (in_array('Mahasiswa', array_map(function($role) { return trim($role, '[]"'); }, (array)
json_decode(Auth::user()->role, true))))
<div class="container-fluid p-0">
    <h1 class="h3 mb-3"><strong>Pengumuman</strong></h1>
</div>
<div class="row">
    <div class="col-lg-8">
        <div class="frame">
            @foreach($pengumuman as $item)
            <div class="frame mt-3">
                <h6 class="card-text">
                    {{ $item->topik_pengumuman }} -
                    @foreach(json_decode($item->user->role) as $role)
                    @if(in_array($role, ['Kantin', 'Asrama', 'Ketertiban']))
                    <span class="badge bg-info">{{ $role }}</span>
                    @endif
                    @endforeach
                </h6>
                <p>{{ $item->tanggal_pengumuman }}</p>
                <a href="{{ route('dashboard.pengumuman_detail', $item->id) }}"
                    class="btn btn-sm btn-primary">Selengkapnya</a>
            </div>
            @endforeach
        </div>
    </div>
    <div class="col-lg-4">
        <div class="frame mt-3">
            <h4>Tempat Makan Kantin</h4>
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td><strong>Kantin</strong></td>
                        <td>
                            @if(isset($detailMeja->kantin) && !empty($detailMeja->kantin))
                            {{ $detailMeja->kantin->nama_kantin }}
                            @else
                            Data kantin tidak tersedia
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Nomor Meja</strong></td>
                        <td>
                            @if(isset($detailMeja->mejaMakan) && !empty($detailMeja->mejaMakan))
                            {{ $detailMeja->mejaMakan->nama_meja }}
                            @else
                            Data meja tidak tersedia
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Teman Semeja</strong></td>
                        <td>
                            <ul class="list-unstyled">
                                @if(isset($mejaDetailLainnya) && count($mejaDetailLainnya) > 0)
                                @foreach($mejaDetailLainnya as $item)
                                <li>{{ $item->mahasiswa->nama }}</li>
                                @endforeach
                                @else
                                Tidak ada teman semeja
                                @endif
                            </ul>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div
            class="frame mt-3 {{ isset($detailPiket->piket) && $detailPiket->piket->active ? 'bg-danger text-white' : '' }}">
            <h4 class="{{ isset($detailPiket->piket) && $detailPiket->piket->active ? 'text-white' : '' }}">Piket
                Kelompok</h4>
            @if(isset($detailPiket->piket) && $detailPiket->piket->active)
            <div>
                Sekarang waktunya kamu piket
            </div>
            @endif
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td class="{{ isset($detailPiket->piket) && $detailPiket->piket->active ? 'text-white' : '' }}">
                            <strong>Kelompok Piket</strong>
                        </td>
                        <td class="{{ isset($detailPiket->piket) && $detailPiket->piket->active ? 'text-white' : '' }}">
                            @if(isset($detailPiket->piket) && !empty($detailPiket->piket))
                            {{ $detailPiket->piket->nama_piket }}
                            @else
                            Data kelompok piket tidak tersedia
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="{{ isset($detailPiket->piket) && $detailPiket->piket->active ? 'text-white' : '' }}">
                            <strong>Teman Sepiket</strong>
                        </td>
                        <td class="{{ isset($detailPiket->piket) && $detailPiket->piket->active ? 'text-white' : '' }}">
                            <ul class="list-unstyled">
                                @if(isset($piketLainnya) && count($piketLainnya) > 0)
                                @foreach($piketLainnya as $item)
                                <li>{{ $item->mahasiswa->nama }}</li>
                                @endforeach
                                @else
                                Tidak ada teman sepiket
                                @endif
                            </ul>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>


@else
<div class="container-fluid p-0">
    <h1 class="h3 mb-3"><strong>Pengumuman</h1>
</div>
<div class="frame">
    @foreach($pengumuman as $item)
    <div class="frame mt-3">
        <h6 class="card-text">
            {{ $item->topik_pengumuman }} -
            @foreach(json_decode($item->user->role) as $role)
            @if(in_array($role, ['Kantin', 'Asrama', 'Ketertiban']))
            <span class="badge bg-info">{{ $role }}</span>
            @endif
            @endforeach
        </h6>
        <p>{{ $item->tanggal_pengumuman }}</p>
        <a href="{{ route('dashboard.pengumuman_detail', $item->id) }}" class="btn btn-sm btn-primary">Selengkapnya</a>
    </div>
    @endforeach
</div>
@endif

@endsection