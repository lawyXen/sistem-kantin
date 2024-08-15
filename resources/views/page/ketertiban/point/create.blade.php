@extends('template.index')

@section('title')
<title>{{ isset($point->id) ? 'Edit Pelanggaran' : 'Tambah Pelanggaran' }}</title>
@endsection

@section('content')
<div class="container-fluid p-0">
    <h1 class="h3 mb-3"><strong>{{ isset($point->id) ? 'Edit Pelanggaran' : 'Form Tambah Pelanggaran' }}</strong></h1>

    <div class="card mb-4">
        <div class="card-body">
            <form id="pointForm">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="tanggal" class="form-label">Tanggal Pelanggaran</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal"
                            value="{{ isset($point->tanggal) ? $point->tanggal : old('tanggal') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="waktu_makan" class="form-label">Waktu Makan</label>
                        <select class="form-select" id="waktu_makan" name="waktu_makan" required>
                            <option selected disabled>Pilih Waktu Makan</option>
                            <option value="Pagi" {{ (isset($point) && $point->waktu_makan == 'Pagi') ? 'selected' : ''
                                }}>Pagi</option>
                            <option value="Siang" {{ (isset($point) && $point->waktu_makan == 'Siang') ? 'selected' : ''
                                }}>Siang</option>
                            <option value="Malam" {{ (isset($point) && $point->waktu_makan == 'Malam') ? 'selected' : ''
                                }}>Malam</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="points" class="form-label">Point Pelanggaran</label>
                        <input type="number" class="form-control" id="points" name="points"
                            value="{{ isset($point->points) ? $point->points : old('points') }}" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="keterangan" class="form-label">Tindakan Mahasiswa</label>
                    <textarea class="form-control" id="keterangan" name="keterangan" rows="4"
                        required>{{ isset($point->keterangan) ? $point->keterangan : old('keterangan') }}</textarea>
                </div>
                <div class="d-flex justify-content-end">
                    <a href="{{ route('point.detail', $mahasiswa->id) }}" class="btn btn-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-primary" id="submitButton"
                        onclick="save_data('#pointForm', '#submitButton', '{{ isset($point->id) ? route('point.update', [$mahasiswa->id, $point->id]) : route('point.store', $mahasiswa->id) }}', '{{ isset($point->id) ? 'PUT' : 'POST' }}');">{{
                        isset($point->id) ? 'Update' : 'Tambah' }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection