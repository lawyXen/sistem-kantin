<?php

namespace App\Http\Controllers\Kantin;

use App\Models\Pengumuman;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PengumumanController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user()->user_id;
        $query = Pengumuman::where('user_id', $user);

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('tanggal_pengumuman', 'LIKE', "%{$search}%")
                    ->orWhere('topik_pengumuman', 'LIKE', "%{$search}%");
            });
        }

        $pengumuman = $query->get();

        if ($request->ajax()) {
            return view('page.kantin.pengumuman.list', compact('pengumuman'))->render();
        }

        return view('page.kantin.pengumuman.main', compact('pengumuman'));
    }


    public function create(){
        return view('page.kantin.pengumuman.create');
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'tanggal_pengumuman' => 'required|date',
            'topik_pengumuman' => 'required|string|max:255',
            'user_id' => 'required|string|max:255',
            'deskripsi' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'alert' => 'error',
                'message' => $validator->errors()->first()
            ]);
        }  

        $pengumuman = new Pengumuman();
        $pengumuman->id = Str::random(16);
        $pengumuman->tanggal_pengumuman = $request->tanggal_pengumuman;
        $pengumuman->topik_pengumuman = $request->topik_pengumuman;
        $pengumuman->user_id = $request->user_id;
        $pengumuman->deskripsi = $request->deskripsi;
        $pengumuman->save();

        return response()->json([
            'alert' => 'success',
            'message' => 'Pengumuman berhasil ditambahkan.',
            'redirect_url' => route('pengumuman.index')
        ]);
    }

    public function show(Pengumuman $pengumuman)
    {
        return view('page.kantin.pengumuman.show', compact('pengumuman'));
    }

    public function edit(Pengumuman $pengumuman)
    {
        return view('page.kantin.pengumuman.create', compact('pengumuman'));
    }

    public function update(Request $request, Pengumuman $pengumuman)
    {
        $validator = Validator::make($request->all(), [
            'tanggal_pengumuman' => 'required|date',
            'topik_pengumuman' => 'required|string|max:255',
            'user_id' => 'required|string|max:255',
            'deskripsi' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'alert' => 'error',
                'message' => $validator->errors()->first()
            ]);
        }  

        $pengumuman->tanggal_pengumuman = $request->tanggal_pengumuman;
        $pengumuman->topik_pengumuman = $request->topik_pengumuman;
        $pengumuman->user_id = $request->user_id;
        $pengumuman->deskripsi = $request->deskripsi;
        $pengumuman->save();

        return response()->json([
            'alert' => 'success',
            'message' => 'Pengumuman berhasil diperbarui.',
            'redirect_url' => route('pengumuman.index')
        ]);
    }

    public function destroy(Pengumuman $pengumuman)
    {
        $pengumuman->delete();

        return response()->json([
            'alert' => 'success',
            'message' => 'Pengumuman berhasil dihapus.', 
        ]);
    }
}