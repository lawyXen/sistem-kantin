<div class="table-responsive">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @if($jadwal->isEmpty())
            <tr>
                <td colspan="3" class="text-center">Tidak ada Jadwal PIC</td>
            </tr>
            @else
            @foreach($jadwal as $item)
            <tr>
                <td>{{ $item->user->username }}</td>
                <td>{{ $item->tanggal }}</td>
                <td>
                    <button type="button" onclick="handle_delete('{{ route('asrama.destroy', $item->id) }}');"
                        class="btn btn-danger">Hapus</button>
                </td>
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>
</div>