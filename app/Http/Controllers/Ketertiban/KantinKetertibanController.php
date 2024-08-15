<?php

namespace App\Http\Controllers\Ketertiban;

use App\Models\User;
use App\Models\Piket;
use App\Models\Kantin;
use App\Models\Mahasiswa;
use App\Models\MejaMakan;
use App\Models\DetailMeja; 
use App\Models\DetailPiket;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class KantinKetertibanController extends Controller
{
    public function index(Request $request, Kantin $kantin)
    {
        $query = DetailMeja::with(['mahasiswa', 'mejaMakan'])
            ->where('kantin_id', $kantin->id);

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('mahasiswa', function($q) use ($search) {
                    $q->where('nama', 'LIKE', "%{$search}%");
                })->orWhereHas('mejaMakan', function($q) use ($search) {
                    $q->where('nama_meja', 'LIKE', "%{$search}%");
                });
            });
        }

        $mahasiswa = $query->paginate(10);

        $mejaMakan = MejaMakan::where('kantin_id', $kantin->id)->get();

        if ($request->ajax()) {
            return view('page.ketertiban.detail-kantin.list', compact('mahasiswa', 'kantin', 'mejaMakan'))->render();
        }

        return view('page.ketertiban.detail-kantin.main', compact('kantin', 'mahasiswa', 'mejaMakan'));
    }


    public function create(Kantin $kantin){

        $mejaMakan = MejaMakan::where('kantin_id', $kantin->id)->get();
        
        $alreadyAssignedMahasiswaIds = DetailMeja::pluck('user_id')->toArray(); 
        $mahasiswas = Mahasiswa::whereNotIn('id', $alreadyAssignedMahasiswaIds)->get();
        
        return view('page.ketertiban.detail-kantin.mahasiswa.create', ['mejaMakan' => $mejaMakan, 'kantin' => $kantin, 'mahasiswa' => new DetailMeja(), 'mahasiswas' => $mahasiswas]);
    }

    public function store(Request $request, Kantin $kantin){
        $validator = Validator::make($request->all(), [
            'nomor_meja' => 'required', 
            'nama_mahasiswa' => 'required'
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'alert' => 'error',
                'message' => $validator->errors()->first()
            ]);
        }
    
        $nomorMejaId = $request->input('nomor_meja');
        $namaMahasiswas = array_map('trim', explode(',', $request->input('nama_mahasiswa')));
    
        // Cek apakah meja sudah memiliki maksimal 6 mahasiswa
        $mahasiswaCount = DetailMeja::where('meja_id', $nomorMejaId)->count();
    
        // Jumlah mahasiswa yang akan ditambahkan
        $newMahasiswaCount = count($namaMahasiswas);
    
        // Validasi jumlah total mahasiswa tidak boleh lebih dari 6
        if (($mahasiswaCount + $newMahasiswaCount) > 6) {
            return response()->json([
                'alert' => 'error',
                'message' => 'Meja sudah memiliki maksimal 6 mahasiswa atau akan melebihi maksimal dengan penambahan baru.'
            ]);
        }
    
        foreach ($namaMahasiswas as $namaMahasiswa) {
            // Validasi nama mahasiswa tidak kosong
            if (empty($namaMahasiswa)) {
                return response()->json([
                    'alert' => 'error',
                    'message' => 'Nama mahasiswa tidak boleh kosong.'
                ]);
            }
    
            // Cari mahasiswa berdasarkan nama
            $mahasiswa = Mahasiswa::where('nama', $namaMahasiswa)->first();
    
            if ($mahasiswa) {
                // Cek apakah mahasiswa sudah ada di meja yang sama
                $existingDetailMejaSameTable = DetailMeja::where('user_id', $mahasiswa->id)
                                                        ->where('meja_id', $nomorMejaId)
                                                        ->first(); 
                if ($existingDetailMejaSameTable) { 
                    return response()->json([
                        'alert' => 'error',
                        'message' => 'Mahasiswa ' . $namaMahasiswa . ' sudah ada di meja ini.'
                    ]);
                }
    
                // Cek apakah mahasiswa sudah ada di meja lain
                $existingDetailMejaOtherTable = DetailMeja::where('user_id', $mahasiswa->id)->first();
                if ($existingDetailMejaOtherTable) {
                    return response()->json([
                        'alert' => 'error',
                        'message' => 'Mahasiswa ' . $namaMahasiswa . ' sudah terdaftar di meja lain.'
                    ]);
                }
    
                // Tambahkan mahasiswa ke meja
                DetailMeja::create([
                    'id' => Str::random(16),
                    'kantin_id' => $kantin->id,
                    'user_id' => $mahasiswa->id,
                    'meja_id' => $nomorMejaId
                ]);
                $mahasiswaCount++;
            } else {
                return response()->json([
                    'alert' => 'error',
                    'message' => 'Mahasiswa dengan nama ' . $namaMahasiswa . ' tidak ditemukan.'
                ]);
            }
        }
    
        return response()->json([
            'alert' => 'success',
            'message' => 'Mahasiswa berhasil ditambahkan ke meja makan.',
            'redirect_url' => route('ketertiban.index', $kantin->id)
        ]); 
    } 

    public function update(Request $request, Kantin $kantin) {
        $request->validate([
            'id' => 'required',
            'meja_id' => 'required',
        ]);
    
        $detailMeja = DetailMeja::find($request->id);
        if (!$detailMeja) { 
            return response()->json([
                'alert' => 'error',
                'message' => 'Data tidak ditemukan.'
            ]);
        }
    
        $mahasiswaCount = DetailMeja::where('meja_id', $request->meja_id)->count();
        if ($mahasiswaCount >= 6) { 
            return response()->json([
                'alert' => 'error',
                'message' => 'Meja sudah memiliki maksimal 6 mahasiswa.'
            ]);
        }
    
        $detailMeja->meja_id = $request->meja_id;
        $detailMeja->save();
    
        return response()->json([
            'alert' => 'success',
            'message' => 'Mahasiswa Berhasil Dipindahkan',
            'redirect_url' => route('ketertiban.index', $kantin->id)
        ]); 
    }
    

    

    public function destroy(Kantin $kantin, DetailMeja $detail){
        
        $detail->delete();

        return response()->json([
            'alert' => 'success',
            'message' => 'Mahasiswa berhasil dihapus.', 
        ]);
    } 




    // Meja

    public function list_meja(Request $request, Kantin $kantin)
    {
        $query = MejaMakan::where('kantin_id', $kantin->id);
        
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('nama_meja', 'LIKE', "%{$search}%");
        }

        $mejaMakans = $query->paginate(10);

        if ($request->ajax()) {
            return view('page.ketertiban.detail-kantin.meja.list', compact('mejaMakans', 'kantin'))->render();
        }

        return view('page.ketertiban.detail-kantin.meja.main', compact('kantin', 'mejaMakans'));
    }


    public function create_meja(Kantin $kantin){
        return view('page.ketertiban.detail-kantin.meja.create', ['kantin' => $kantin, 'meja' => new MejaMakan()]);
    }

    public function store_meja(Request $request, Kantin $kantin){
        $validator = Validator::make($request->all(), [
            'nama_meja' => 'required', 
        ]);

        if ($validator->fails()) {
            return response()->json([
                'alert' => 'error',
                'message' => $validator->errors()->first()
            ]);
        }

        $meja = new MejaMakan();
        $meja->id = Str::random(16);  
        $meja->kantin_id = $kantin->id; 
        $meja->nama_meja = $request->nama_meja;
        $meja->save();

        return response()->json([
            'alert' => 'success',
            'message' => 'Menu berhasil ditambahkan.',
            'redirect_url' => route('ketertiban.list_meja', $kantin->id)
        ]);
    }

    public function edit_meja(Kantin $kantin, MejaMakan $meja)
    {
        return view('page.ketertiban.detail-kantin.meja.create', [
            'kantin' => $kantin,
            'meja' => $meja
        ]);
    }

    public function update_meja(Request $request, Kantin $kantin, MejaMakan $meja)
    {
        $validator = Validator::make($request->all(), [
            'nama_meja' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'alert' => 'error',
                'message' => $validator->errors()->first()
            ]);
        }

        $meja->nama_meja = $request->nama_meja;
        $meja->save();

        return response()->json([
            'alert' => 'success',
            'message' => 'Meja berhasil diperbarui.',
            'redirect_url' => route('ketertiban.list_meja', $kantin->id)
        ]);
    }

    public function destroy_meja(Kantin $kantin, MejaMakan $meja){
        $meja->delete();

        return response()->json([
            'alert' => 'success',
            'message' => 'Meja berhasil dihapus.', 
        ]);
    } 

    // Piket

    public function piket_index(Request $request, Kantin $kantin)
    {
        // Dapatkan semua data piket terkait kantin
        $piket = Piket::where('kantin_id', $kantin->id)->orderBy('created_at', 'asc')->get();

        // Dapatkan ID mahasiswa yang sudah ada di detailPikets
        $existingMahasiswaIds = DetailPiket::whereHas('piket', function ($query) use ($kantin) {
            $query->where('kantin_id', $kantin->id);
        })->pluck('user_id');

        // Dapatkan semua mahasiswa yang belum ada di detailPikets terkait kantin
        $mahasiswas = Mahasiswa::whereHas('detailMeja', function ($query) use ($kantin) {
            $query->where('kantin_id', $kantin->id);
        })->whereNotIn('id', $existingMahasiswaIds)->get(); 

        $activePiket = Piket::where('kantin_id', $kantin->id)->where('active', 1)->first();

        return view('page.ketertiban.piket.main', compact('kantin', 'piket', 'mahasiswas', 'activePiket'));
    }

    public function ganti_piket(Request $request, Kantin $kantin)
    {
        $request->validate([
            'piket_id' => 'required|exists:pikets,id'
        ]);

        // Menonaktifkan piket yang sedang aktif di kantin yang sama
        Piket::where('kantin_id', $kantin->id)->where('active', 1)->update(['active' => 0]);

        // Mengaktifkan piket yang dipilih
        $piket = Piket::find($request->piket_id);
        $piket->active = 1;
        $piket->save();

        return response()->json([
            'alert' => 'success',
            'message' => 'Jadwal Piket Berubah',
            'redirect_url' => route('ketertiban.piket_index', $kantin->id)
        ]);
    }

    public function update_mahasiswa(Request $request, Kantin $kantin)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'detail_piket_id' => 'required',
            'edit_nama_piket' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'alert' => 'error',
                'message' => $validator->errors()->first()
            ]);
        }

        $detailPiketId = $request->input('detail_piket_id');
        $newPiketId = $request->input('edit_nama_piket');

        $detailPiket = DetailPiket::find($detailPiketId);

        if (!$detailPiket) {
            return response()->json([
                'alert' => 'error',
                'message' => 'Detail piket tidak ditemukan.'
            ]);
        }

        // Update piket mahasiswa
        $detailPiket->piket_id = $newPiketId;
        $detailPiket->save();

        return response()->json([
            'alert' => 'success',
            'message' => 'Mahasiswa berhasil dipindahkan ke piket baru.',
            'redirect_url' => route('ketertiban.piket_index', $kantin->id)
        ]);
    }

    

    public function piket_store(Request $request, Kantin $kantin){ 
        
        $validator = Validator::make($request->all(), [
            'nama_piket' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'alert' => 'error',
                'message' => $validator->errors()->first()
            ]);
        }
        $piket = new Piket();
        $piket->id = Str::random(16);
        $piket->kantin_id = $kantin->id;
        $piket->nama_piket = $request->nama_piket;
        $piket->save();

        return response()->json([
            'alert' => 'success',
            'message' => 'Meja berhasil diperbarui.',
            'redirect_url' => route('ketertiban.piket_index', $kantin->id)
        ]);
    }

    public function piket_store_mahasiswa(Request $request, Kantin $kantin)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama_piket' => 'required',
            'nama_mahasiswa' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'alert' => 'error',
                'message' => $validator->errors()->first()
            ]);
        }

        $namaPiket = $request->input('nama_piket');
        $namaMahasiswas = explode(',', $request->input('nama_mahasiswa'));
        $errors = [];

        foreach ($namaMahasiswas as $namaMahasiswa) {
            $namaMahasiswa = trim($namaMahasiswa);

            // Cari mahasiswa berdasarkan nama
            $mahasiswa = Mahasiswa::where('nama', $namaMahasiswa)->first();

            if (!$mahasiswa) {
                $errors[] = "Mahasiswa dengan nama $namaMahasiswa tidak ditemukan.";
                continue;
            }

            // Cek apakah mahasiswa sudah ada di detail piket yang lain
            $existingDetailPiket = DetailPiket::where('user_id', $mahasiswa->id)
                                                ->whereHas('piket', function ($query) use ($kantin) {
                                                    $query->where('kantin_id', $kantin->id);
                                                })
                                                ->first();

            if ($existingDetailPiket) {
                $errors[] = "Mahasiswa $namaMahasiswa sudah terdaftar di kelompok piket lain.";
                continue;
            }

            // Tambahkan mahasiswa ke detail piket jika belum ada
            DetailPiket::create([
                'id' => Str::random(16),
                'piket_id' => $namaPiket,
                'user_id' => $mahasiswa->id
            ]);
        }

        if (!empty($errors)) {
            return response()->json([
                'alert' => 'error',
                'message' => implode(' ', $errors)
            ]);
        }

        return response()->json([
            'alert' => 'success',
            'message' => 'Mahasiswa berhasil ditambahkan ke piket.',
            'redirect_url' => route('ketertiban.piket_index', $kantin->id)
        ]);
    }

    public function delete_mahasiswa(Request $request, Kantin $kantin, DetailPiket $id)
    { 
        // Hapus id piket
        $id->delete();

        return response()->json([
            'alert' => 'success',
            'message' => 'Mahasiswa berhasil dihapus dari piket.', 
        ]);
    }

    public function delete_jadwal(Request $request, Kantin $kantin, Piket $id)
    { 
        // Hapus id piket
        $id->delete();

        return response()->json([
            'alert' => 'success',
            'message' => 'Mahasiswa berhasil dihapus dari piket.', 
        ]);
    }





}