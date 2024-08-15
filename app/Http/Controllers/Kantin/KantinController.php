<?php

namespace App\Http\Controllers\Kantin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Kantin;
use App\Models\PicKantin;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class KantinController extends Controller
{
    public function index(Request $request)
    {
        $query = Kantin::query();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('nama_kantin', 'LIKE', "%{$search}%");
        }

        $kantins = $query->get();

        if ($request->ajax()) {
            return view('page.kantin.kantin.list', compact('kantins'))->render();
        }

        $asrama = User::whereJsonContains('role', 'Asrama')->get(); 
        $dataJadwalPic = [];
        $today = Carbon::today()->toDateString(); // Mendapatkan tanggal hari ini dalam format YYYY-MM-DD

        foreach ($kantins as $kantin) {
            $dataJadwalPic[$kantin->id] = PicKantin::where('kantin_id', $kantin->id)
                ->whereDate('tanggal', $today)
                ->with('user')
                ->get();
        }

        return view('page.kantin.kantin.main', compact('kantins', 'asrama', 'dataJadwalPic'));
    }


    public function create()
    {
        return view('page.kantin.kantin.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_kantin' => 'required|string|max:255',
            'gambar_kantin' => 'required|image',
            'gambar_denah' => 'required|image',
            'deskripsi' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'alert' => 'error',
                'message' => $validator->errors()->first()
            ]);
        }

        $gambarKantin = $request->file('gambar_kantin')->store('public/gambar_kantin');
        $gambarDenah = $request->file('gambar_denah')->store('public/gambar_denah');

        $kantin = new Kantin();
        $kantin->id = Str::random(16);
        $kantin->nama_kantin = $request->nama_kantin;
        $kantin->gambar_kantin = str_replace('public/', '', $gambarKantin);
        $kantin->gambar_denah = str_replace('public/', '', $gambarDenah);
        $kantin->deskripsi = $request->deskripsi;  
        $kantin->save();

        return response()->json([
            'alert' => 'success',
            'message' => 'Kantin berhasil ditambahkan.',
            'redirect_url' => route('kantin.index')
        ]);
    }

    public function edit(Kantin $kantin)
    {
        return view('page.kantin.kantin.create', compact('kantin'));
    }

    public function update(Request $request, Kantin $kantin)
    {
        $validator = Validator::make($request->all(), [
            'nama_kantin' => 'required|string|max:255',
            'gambar_kantin' => 'nullable|image',
            'gambar_denah' => 'nullable|image',
            'deskripsi' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'alert' => 'error',
                'message' => $validator->errors()->first()
            ]);
        }

        if ($request->hasFile('gambar_kantin')) {
            $gambarKantin = $request->file('gambar_kantin')->store('public/gambar_kantin');
            $kantin->gambar_kantin = str_replace('public/', '', $gambarKantin);
        }

        if ($request->hasFile('gambar_denah')) {
            $gambarDenah = $request->file('gambar_denah')->store('public/gambar_denah');
            $kantin->gambar_denah = str_replace('public/', '', $gambarDenah);
        }

        $kantin->nama_kantin = $request->nama_kantin;
        $kantin->deskripsi = $request->deskripsi;
        $kantin->save();

        return response()->json([
            'alert' => 'success',
            'message' => 'Kantin berhasil diperbarui.',
            'redirect_url' => route('kantin.index')
        ]);
    }

    public function destroy(Kantin $kantin)
    {
        $kantin->delete();

        return response()->json([
            'alert' => 'success',
            'message' => 'Kantin berhasil dihapus.',
        ]);
    }
}