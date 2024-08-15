@forelse ($mahasiswa as $item)
<tr>
    <td>{{ $loop->iteration }}</td>
    <td>{{ $item->mahasiswa->nama }}</td>
    <td>{{ $item->mahasiswa->prodi }}</td>
    <td>{{ $item->mahasiswa->angkatan }}</td>
    <td>{{ $item->mejaMakan->nama_meja }}</td>
    @if ($shouldShowActionButtons)
    <td>
        {{-- <a href="#" class="btn btn-info btn-sm"><i class="align-middle" data-feather="eye"></i> Lihat</a> --}}
        <a href="#" class="btn btn-warning btn-sm"
            onclick="openEditModal('{{ $item->id }}', '{{ $item->mahasiswa->nama }}', '{{ $item->meja_id }}')"><i
                class="align-middle" data-feather="edit"></i> Ubah</a>
        <a class="btn btn-danger btn-sm"
            onclick="handle_delete('{{ route('ketertiban.destroy', [$kantin->id, $item->id]) }}');"><i
                class="align-middle"></i> Hapus</a>
    </td>
    @endif
</tr>
@empty
<tr>
    <td colspan="6" class="text-center">Tidak ada mahasiswa</td>
</tr>
@endforelse