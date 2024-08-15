<?php

namespace App\Http\Controllers\Asrama;

use App\Models\User;
use App\Models\Kantin;
use App\Models\PicKantin;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PicController extends Controller
{

    public function index(Request $request, Kantin $kantin)
    {
        $query = PicKantin::with('user')->where('kantin_id', $kantin->id);

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('username', 'LIKE', "%{$search}%");
            });
        }

        $jadwal = $query->get();

        if ($request->ajax()) {
            return view('page.asrama.list', compact('jadwal'))->render();
        }

        return view('page.asrama.main', compact('kantin', 'jadwal'));
    }

    public function create(Kantin $kantin) 
    {
        $asrama = User::whereJsonContains('role', 'Asrama')->get();
        
        return view('page.asrama.create', compact('kantin', 'asrama'));
    }


    

    public function store(Request $request, Kantin $kantin)
    {   
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'pemilihan_tanggal   ' => 'required',
        ]);     

        $pic = new PicKantin;
        $pic->id = Str::random(16);
        $pic->kantin_id = $kantin->id;
        $pic->user_id = $request->user_id;
        $pic->tanggal = $request->pemilihan_tanggal;
        $pic->save();

        return response()->json([
            'alert' => 'success',
            'message' => 'Jadwal PIC berhasil ditambahkan.',
            'redirect_url' => route('asrama.index', $kantin->id)
        ]);
    }

    public function destroy(PicKantin $pic)
    {
        $pic->delete();

        return response()->json([
            'alert' => 'success',
            'message' => 'PIC Kantin berhasil dihapus.',
        ]);
    }
}
