@forelse ($barang as $item)
<tr>
    <td>{{ $loop->iteration }}</td>
    <td>{{ $item->name }}</td>
    <td>{!! $item->description !!}</td>
    <td>{{ $item->stock }}</td>
    <td>{{ $item->satuan }}</td>
    <td>
        @if (in_array('SuperAdmin', array_map(function($role) { return trim($role, '[]"'); }, (array)
        json_decode(Auth::user()->role, true))))
        @else
        <a href="{{ route('barang.show', $item->id) }}" class="btn btn-info btn-sm"><i class="align-middle"
                data-feather="eye"></i> Lihat</a>
        <a href="{{ route('barang.edit', $item->id) }}" class="btn btn-warning btn-sm"><i class="align-middle"
                data-feather="edit"></i> Ubah</a>
        <a class="btn btn-danger btn-sm" onclick="handle_delete('{{ route('barang.destroy', $item->id) }}');">
            <i class="align-middle"></i> Hapus</a>
        @endif
    </td>
</tr>
@empty
<tr>
    <td colspan="6" class="text-center">Tidak ada barang</td>
</tr>
@endforelse