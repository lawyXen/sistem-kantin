@extends('template.index')

@section('title')
<title>Point Pelanggaran </title>
@endsection

@section('content')
<div class="container-fluid p-0">
    <h1 class="h3 mb-3"><strong>Point Pelanggaran Mahasiswa</strong></h1>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    {{-- <h5 class="card-title mb-0">Semester Genap</h5> --}}
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Waktu</th>
                                    <th>Unit</th>
                                    <th>Poin</th>
                                    <th>Tindakan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($point as $item)
                                <tr>
                                    <td>{{ $item->tanggal }}</td>
                                    <td>{{ $item->waktu_makan }}</td>
                                    <td>
                                        @if($item->dibuat)
                                        @php
                                        $roles = json_decode($item->user->role, true);
                                        $filteredRoles = array_filter($roles, function($role) {
                                        return in_array($role, ['Ketertiban', 'Asrama']);
                                        });
                                        echo implode(', ', $filteredRoles);
                                        @endphp
                                        @else
                                        User not found
                                        @endif
                                    </td>
                                    <td>{{ $item->points }}</td>
                                    <td>{{ $item->keterangan }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection