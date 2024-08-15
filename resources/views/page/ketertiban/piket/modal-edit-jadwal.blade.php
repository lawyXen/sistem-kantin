<!-- Modal Ganti Jadwal Piket -->
<div id="editJadwal" class="custom-modal">
    <div class="custom-modal-content">
        <div class="custom-modal-header">
            <h5 class="custom-modal-title" id="editModalLabel">Ganti Jadwal Piket</h5>
            <button type="button" class="custom-modal-close" onclick="closeeditJadwal()">&times;</button>
        </div>
        <div class="custom-modal-body">
            <form id="jadwalForm">
                <div class="mb-3">
                    <label for="piket_id" class="form-label">Jadwal</label>
                    <select class="form-select" id="piket_id" name="piket_id">
                        @foreach($piket as $kelompok)
                        <option value="{{ $kelompok->id }}">{{ $kelompok->nama_piket }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary" id="submitButton"
                    onclick="save_data('#jadwalForm', '#submitButton', '{{ route('ketertiban.ganti_piket', $kantin->id) }}', 'POST');">Simpan</button>
            </form>
        </div>
    </div>
</div>