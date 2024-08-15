@forelse ($pengumuman as $item)
<tr>
    <td>{{ $loop->iteration }}</td>
    <td>{{ $item->tanggal_pengumuman }}</td>
    <td>{{ $item->topik_pengumuman }}</td>
    <td>{{ $item->user->username }}</td>
    <td>
        <a href="{{ route('pengumuman.show', $item->id) }}" class="btn btn-info btn-sm"><i class="align-middle"
                data-feather="eye"></i> Lihat</a>
        <a href="{{ route('pengumuman.edit', $item->id) }}" class="btn btn-warning btn-sm"><i class="align-middle"
                data-feather="edit"></i> Ubah</a>
        <a class="btn btn-danger btn-sm" onclick="handle_delete('{{ route('pengumuman.destroy', $item->id) }}');">
            <i class="align-middle"></i> Hapus</a>
    </td>
</tr>
@empty
<tr>
    <td colspan="5" class="text-center">Tidak ada pengumuman</td>
</tr>
@endforelse