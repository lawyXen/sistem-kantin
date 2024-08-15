@extends('template.index')

@section('title')
<title>Tambah Mahasiswa Ke Meja Makan</title>
@endsection

@section('content')
<div class="container-fluid p-0">
    <h1 class="h3 mb-3"><strong>Tambah Mahasiswa Ke Meja Makan</strong></h1>
    <div class="card">
        <div class="card-body">
            <form id="formId">
                <div class="mb-3">
                    <label for="nomor_meja" class="form-label">Nomor Meja Makan</label>
                    <select class="form-select" id="nomor_meja" name="nomor_meja" required>
                        <option selected disabled>Pilih nomor meja...</option>
                        @foreach($mejaMakan as $meja)
                        <option value="{{ $meja->id }}">{{ $meja->nama_meja }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="nama_mahasiswa" class="form-label">Nama Mahasiswa Semeja (Maksimal 6 orang)</label>
                    <textarea class="form-control" id="nama_mahasiswa" name="nama_mahasiswa" rows="4" maxlength="1000"
                        oninput="updateMahasiswaList()"></textarea>
                    <small class="text-muted">Nama akan otomatis masuk dari tabel bawah</small>
                </div>
                <div class="mb-3">
                    <a href="#" onclick="cancelForm('{{ route('ketertiban.index', $kantin->id) }}')"
                        class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary" id="submitButton"
                        onclick="save_data('#formId', '#submitButton', '{{ route('ketertiban.store', $kantin->id) }}', 'POST');">Tambah</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-body">
            <h5 class="card-title">Daftar Mahasiswa</h5>
            <input type="text" id="searchInput" class="form-control mb-3" placeholder="Cari nama mahasiswa..."
                oninput="filterMahasiswa()">
            <table class="table table-bordered" id="mahasiswaTable">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($mahasiswas as $mahasiswa)
                    <tr id="mahasiswa-{{ $mahasiswa->id }}">
                        <td>{{ $mahasiswa->nama }}</td>
                        <td><button type="button" class="btn btn-success btn-sm"
                                onclick="addToTextarea('{{ $mahasiswa->nama }}', '{{ $mahasiswa->id }}')">Tambah</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    let addedMahasiswa = [];

    function addToTextarea(name, id) {
        const textarea = document.getElementById('nama_mahasiswa');
        let currentText = textarea.value.trim();
        if (currentText.length > 0) {
            currentText += ', ';
        }
        textarea.value = currentText + name;
        
        // Remove the row from the table
        const row = document.getElementById('mahasiswa-' + id);
        row.parentNode.removeChild(row);
        
        // Add to the added list
        addedMahasiswa.push({ name: name, id: id });
    }
    
    function updateMahasiswaList() {
        const textarea = document.getElementById('nama_mahasiswa');
        const currentText = textarea.value.split(',').map(item => item.trim());
        
        // Find removed names
        addedMahasiswa = addedMahasiswa.filter(mahasiswa => {
            if (!currentText.includes(mahasiswa.name)) {
                // Add the row back to the table
                const table = document.getElementById('mahasiswaTable').getElementsByTagName('tbody')[0];
                const newRow = table.insertRow();
                newRow.setAttribute('id', 'mahasiswa-' + mahasiswa.id);
                newRow.innerHTML = `
                    <td>${mahasiswa.name}</td>
                    <td><button type="button" class="btn btn-success btn-sm" onclick="addToTextarea('${mahasiswa.name}', '${mahasiswa.id}')">Tambah</button></td>
                `;
                return false; // Remove from added list
            }
            return true;
        });
    }

    function filterMahasiswa() {
        const searchInput = document.getElementById('searchInput').value.toLowerCase();
        const rows = document.querySelectorAll('#mahasiswaTable tbody tr');
        
        rows.forEach(row => {
            const name = row.querySelector('td').innerText.toLowerCase();
            if (name.includes(searchInput)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    } 
</script>
@endsection