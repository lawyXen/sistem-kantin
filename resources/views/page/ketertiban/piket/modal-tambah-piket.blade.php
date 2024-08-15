<div id="editModal" class="custom-modal">
    <div class="custom-modal-content">
        <div class="custom-modal-header">
            <h5 class="custom-modal-title" id="editModalLabel">Tambah Jadwal Piket</h5>
            <button type="button" class="custom-modal-close" onclick="closeModal()">&times;</button>
        </div>
        <div class="custom-modal-body">
            <form id="editForm">
                <div class="mb-3">
                    <label for="nama_piket" class="form-label">Jadwal</label>
                    <input type="text" class="form-control" id="nama_piket" name="nama_piket">
                </div>
                <button type="submit" class="btn btn-primary" id="submitButton"
                    onclick="save_data('#editForm', '#submitButton', '{{ route('ketertiban.piket_store', $kantin->id) }}', 'POST');">Simpan</button>
            </form>
        </div>
    </div>
</div>