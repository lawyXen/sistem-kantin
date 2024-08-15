@forelse ($mejaMakans as $item)
<tr>
    <td>{{ $loop->iteration }}</td>
    <td>{{ $item->nama_meja }}</td>
    <td>
        {{-- <a href="#" class="btn btn-info btn-sm"><i class="align-middle" data-feather="eye"></i> Lihat</a> --}}
        <a href="{{ route('ketertiban.edit_meja',[$kantin->id, $item->id]) }}" class="btn btn-warning btn-sm"><i
                class="align-middle" data-feather="edit"></i> Ubah</a>
        <a class="btn btn-danger btn-sm"
            onclick="handle_delete('{{ route('ketertiban.destroy_meja', [$kantin->id, $item->id]) }}');"><i
                class="align-middle"></i>
            Hapus</a>
    </td>
</tr>
@empty
<tr>
    <td colspan="3" class="text-center">Tidak ada meja</td>
</tr>
@endforelse