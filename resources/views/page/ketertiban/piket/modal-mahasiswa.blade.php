<div id="editModals" class="custom-modal">
    <div class="p-2 custom-modal-content">
        <h1 class="h3 mb-3"><strong>Tambah Mahasiswa Ke Jadwal Piket</strong></h1>
        <div class="card">
            <div class="card-body">
                <form id="formId">
                    <div class="mb-3">
                        <label for="nama_piket" class="form-label">Nama Kelompok Piket</label>
                        <select class="form-select" id="nama_piket" name="nama_piket" required>
                            <option selected disabled>Pilih nama piket...</option>
                            @foreach($piket as $item)
                            <option value="{{ $item->id }}">{{ $item->nama_piket }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="nama_mahasiswa" class="form-label">Nama Mahasiswa Piket</label>
                        <textarea class="form-control" id="nama_mahasiswa" name="nama_mahasiswa" rows="4"
                            maxlength="1000" oninput="updateMahasiswaList()"></textarea>
                        <small class="text-muted">Nama akan otomatis masuk dari tabel bawah</small>
                    </div>
                    <div class="mb-3">
                        <a href="#" onclick="cancelForm('{{ route('ketertiban.piket_index', $kantin->id) }}')"
                            class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary" id="submitButton"
                            onclick="save_data('#formId', '#submitButton', '{{ route('ketertiban.piket_store_mahasiswa', $kantin->id) }}', 'POST');">Tambah</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-body">
                <h5 class="card-title">Daftar Mahasiswa yang makan di {{ $kantin->nama_kantin }}</h5>
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
</div>