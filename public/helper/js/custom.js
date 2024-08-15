function openEditModal(id, nama, meja_id) {
    document.getElementById('mahasiswaId').value = id;
    document.getElementById('nama_mahasiswa').value = nama;
    document.getElementById('meja_id').value = meja_id;
    document.getElementById('editModal').style.display = 'block';
}

function openEditModals(id) {
    document.getElementById('editModal').style.display = 'block';
}

function openTambahMahasiswa(id) {
    document.getElementById('editModals').style.display = 'block';
}

function openJadwalModal(id) {
    document.getElementById('editJadwal').style.display = 'block';
}



function openEditMahasiswaModal(detailPiketId, mahasiswaName) {
    document.getElementById('editMahasiswaModal').style.display = 'block';
    document.getElementById('detail_piket_id').value = detailPiketId;
    document.getElementById('edit_nama_mahasiswa').value = mahasiswaName;
}

function openDeleteMahasiswaModal(detailPiketId, mahasiswaName) {
    document.getElementById('deleteMahasiswaModal').style.display = 'block';
    document.getElementById('delete_detail_piket_id').value = detailPiketId;
    document.getElementById('delete_mahasiswa_name').textContent = mahasiswaName;
}

function closeModal() {
    document.getElementById('editModal').style.display = 'none';
}

function closepicJadwal() {
    document.getElementById('editPicJadwal').style.display = 'none';
}

function closeeditJadwal() {
    document.getElementById('editJadwal').style.display = 'none';
}

window.onclick = function (event) {
    if (event.target == document.getElementById('editModal')) {
        closeModal();
    }
}
