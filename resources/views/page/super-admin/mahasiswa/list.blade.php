@forelse ($mahasiswa as $item)
<tr>
    <td>{{ $loop->iteration }}</td>
    <td>{{ $item->nama }}</td>
    <td>{{ $item->nim }}</td>
    <td>{{ $item->prodi }}</td>
    <td>{{ $item->angkatan }}</td>
    <td>
        <a href="{{ route('mahasiswa.show', $item->id) }}" class="btn btn-info btn-sm"><i class="align-middle"
                data-feather="eye"></i> Lihat</a>
        <a href="{{ route('mahasiswa.edit', $item->id) }}" class="btn btn-warning btn-sm"><i class="align-middle"
                data-feather="edit"></i> Ubah</a>
        <a class="btn btn-danger btn-sm" onclick="handle_delete('{{ route('mahasiswa.destroy', $item->id) }}');">
            <i class="align-middle"></i> Hapus</a>
    </td>
</tr>
@empty
<tr>
    <td colspan="6" class="text-center">Tidak ada Mahasiswa</td>
</tr>
@endforelse