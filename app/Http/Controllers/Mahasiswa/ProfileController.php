<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function edit($profile)
    { 
        $mahasiswa = Mahasiswa::where('nim', $profile)->first();
        
        return view('page.mahasiswa.create', compact('mahasiswa'));
    }

    public function update(Request $request, Mahasiswa $profile)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'nim' => 'required|string|max:255',
            'prodi' => 'required|string|max:255',
            'angkatan' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'username' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'alert' => 'error',
                'message' => $validator->errors()->first()
            ]);
        }   

        $profile->nama = $request->nama;
        $profile->nim = $request->nim;
        $profile->prodi = $request->prodi;
        $profile->angkatan = $request->angkatan;
        $profile->email = $request->email;
        $profile->username = $request->username;
        $profile->save();

        return response()->json([
            'alert' => 'success',
            'message' => 'Data mahasiswa berhasil diperbarui.',
            'redirect_url' => route('profile.mahasiswa', $profile->username)
        ]);
    }
}
