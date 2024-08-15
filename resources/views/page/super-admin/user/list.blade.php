@forelse ($users as $item)
<tr>
    <td>{{ $loop->iteration }}</td>
    <td>{{ $item->username }}</td>
    <td>
        @php
        $roles = json_decode($item->role, true);
        @endphp

        @if (is_array($roles))
        @foreach ($roles as $role)
        <span class="badge bg-info">{{ $role }}</span>
        @endforeach
        @else
        <span class="badge bg-warning">No roles assigned</span>
        @endif
    </td>
    <td>
        {{-- <a href="{{ route('user.show', $item->user_id) }}" class="btn btn-info btn-sm"><i class="align-middle"
                data-feather="eye"></i> Lihat</a>
        <a href="{{ route('user.edit', $item->user_id) }}" class="btn btn-warning btn-sm"><i class="align-middle"
                data-feather="edit"></i> Ubah</a> --}}
        <button class="btn btn-success btn-sm btn-add-role" data-user-id="{{ $item->user_id }}"
            data-url="{{ route('user.addRole') }}" data-method="POST"><i class="align-middle" data-feather="plus"></i>
            Tambah Role</button>
        <button class="btn btn-danger btn-sm btn-remove-role" data-user-id="{{ $item->user_id }}"
            data-roles="{{ json_encode($roles) }}" data-url="{{ route('user.removeRole') }}" data-method="POST"><i
                class="align-middle" data-feather="minus"></i> Hapus Role</button>
    </td>
</tr>
@empty
<tr>
    <td colspan="5" class="text-center">Tidak ada user</td>
</tr>
@endforelse