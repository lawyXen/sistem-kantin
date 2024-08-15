<?php

namespace App\Http\Controllers\Utils;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use App\Imports\MahasiswaImport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class MahasiswaController extends Controller
{
    public function index(Request $request)
    {   
        $query = Mahasiswa::query();
        
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('username', 'LIKE', "%{$search}%")
                    ->orWhere('nama', 'LIKE', "%{$search}%")
                    ->orWhere('nim', 'LIKE', "%{$search}%")
                    ->orWhere('prodi', 'LIKE', "%{$search}%")
                    ->orWhere('angkatan', 'LIKE', "%{$search}%")
                    ->orWhere('username', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%");
            });
        } 
        $mahasiswa = $query->paginate(10); // Ubah dari get() ke paginate()

        if ($request->ajax()) {
            return view('page.super-admin.mahasiswa.list', compact('mahasiswa'))->render();
        }
        
        return view('page.super-admin.mahasiswa.main', compact('mahasiswa'));
}

    public function import(Request $request){
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:xlsx,xls', 
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'alert' => 'error',
                'message' => $validator->errors()->first()
            ]);
        }

        $import = new MahasiswaImport;
        Excel::import($import, $request->file('file'));

        if ($import->getInvalidHeaders()) {
            return response()->json([
                'alert' => 'error',
                'message' => 'Template Excel tidak sesuai dengan yang diharapkan.',
            ]);
        }

        $duplicateNims = $import->getDuplicateNims();

        if (!empty($duplicateNims)) {
            return response()->json([
                'alert' => 'warning',
                'message' => 'Beberapa NIM sudah ada: ' . implode(', ', $duplicateNims),
                'duplicate_nims' => $duplicateNims,
            ]);
        }

        return response()->json([
            'alert' => 'success',
            'message' => 'Mahasiswa berhasil ditambahkan',
            'redirect_url' => route('mahasiswa.index')
        ]);
    }

    public function destroy(Mahasiswa $mahasiswa)
    {
        $mahasiswa->delete();

        return response()->json([
            'alert' => 'success',
            'message' => 'Mahasiswa berhasil dihapus.', 
        ]);
    }

    public function show(Mahasiswa $mahasiswa)
    {
        return view('page.super-admin.mahasiswa.show', compact('mahasiswa'));
    }

    public function edit($id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        return view('page.super-admin.mahasiswa.create', compact('mahasiswa'));
    }

    public function update(Request $request, Mahasiswa $mahasiswa)
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

        // Cek apakah sudah ada NIM yang sama kecuali mahasiswa ini
        $existingMahasiswa = Mahasiswa::where('nim', $request->nim)->where('id', '!=', $mahasiswa->id)->first();
        if ($existingMahasiswa) {
            return response()->json([
                'alert' => 'error',
                'message' => 'NIM sudah ada.'
            ]);
        }

        $mahasiswa->nama = $request->nama;
        $mahasiswa->nim = $request->nim;
        $mahasiswa->prodi = $request->prodi;
        $mahasiswa->angkatan = $request->angkatan;
        $mahasiswa->email = $request->email;
        $mahasiswa->username = $request->username;
        $mahasiswa->save();

        return response()->json([
            'alert' => 'success',
            'message' => 'Data mahasiswa berhasil diperbarui.',
            'redirect_url' => route('mahasiswa.index')
        ]);
    }
}
