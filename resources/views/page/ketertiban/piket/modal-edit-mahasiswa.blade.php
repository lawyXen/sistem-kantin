<div id="editMahasiswaModal" class="custom-modal">
    <div class="p-2 custom-modal-content">
        <h1 class="h3 mb-3"><strong>Ubah Mahasiswa Piket</strong></h1>
        <div class="card">
            <div class="card-body">
                <form id="editFormId" method="POST">
                    @csrf
                    <input type="hidden" id="detail_piket_id" name="detail_piket_id">
                    <div class="mb-3">
                        <label for="edit_nama_piket" class="form-label">Nama Kelompok Piket</label>
                        <select class="form-select" id="edit_nama_piket" name="edit_nama_piket" required>
                            <option selected disabled>Pilih nama piket...</option>
                            @foreach($piket as $item)
                            <option value="{{ $item->id }}">{{ $item->nama_piket }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_nama_mahasiswa" class="form-label">Nama Mahasiswa</label>
                        <input type="text" class="form-control" id="edit_nama_mahasiswa" name="edit_nama_mahasiswa"
                            readonly>
                    </div>
                    <div class="mb-3">
                        <a href="{{ route('ketertiban.piket_index', $kantin->id) }}" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary" id="editSubmitButton"
                            onclick="save_data('#editFormId', '#editSubmitButton', '{{ route('ketertiban.update_mahasiswa', $kantin->id) }}', 'PUT');">Ubah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>