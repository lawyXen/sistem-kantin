<?php

namespace App\Http\Controllers\Utils;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CreateUserController extends Controller
{
    public function index(Request $request)
    {   
        $query = User::whereRaw('NOT JSON_CONTAINS(role, \'["SuperAdmin"]\')');
        
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('username', 'LIKE', "%{$search}%");
            });
        } 
        $users = $query->get();
        
        if ($request->ajax()) {
            return view('page.super-admin.user.list', compact('users'))->render();
        }
        
        return view('page.super-admin.user.main', compact('users'));
    } 

    public function addRole(Request $request)
    {
        $user = User::findOrFail($request->user_id); 
        // Ambil role saat ini
        $currentRoles = json_decode($user->role, true);

        if (!is_array($currentRoles)) {
            $currentRoles = [];
        }

        // Tambahkan role baru jika belum ada
        if ($request->has('new_role')) {
            $newRole = $request->new_role;
            if (!in_array($newRole, $currentRoles)) {
                $currentRoles[] = $newRole;
                $user->role = json_encode($currentRoles); // Simpan sebagai JSON
                $user->save();

                return response()->json([
                    'alert' => 'success',
                    'message' => 'Role Berhasil ditambahkan',
                    'redirect_url' => route('user.index')
                ]);
            } else {
                return response()->json([
                    'alert' => 'warning',
                    'message' => 'Role sudah ada',
                    'redirect_url' => route('user.index')
                ]);
            }
        }

        return response()->json([
            'alert' => 'error',
            'message' => 'Role tidak ditemukan dalam permintaan',
            'redirect_url' => route('user.index')
        ]);
    }

    public function removeRole(Request $request)
    {
        $user = User::findOrFail($request->user_id);

        // Ambil role saat ini
        $currentRoles = json_decode($user->role, true);

        if (is_array($currentRoles)) {
            // Hapus role jika ada
            $newRoles = array_diff($currentRoles, [$request->remove_role]);
            $user->role = json_encode(array_values($newRoles)); // Simpan sebagai JSON
            $user->save();

            return response()->json([
                'alert' => 'success',
                'message' => 'Role berhasil dihapus',
                'redirect_url' => route('user.index')
            ]);
        }

        return response()->json([
            'alert' => 'error',
            'message' => 'Role tidak ditemukan',
            'redirect_url' => route('user.index')
        ]);
    }

    
    
}
