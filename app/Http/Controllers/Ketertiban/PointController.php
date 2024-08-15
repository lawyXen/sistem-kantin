<?php

namespace App\Http\Controllers\Ketertiban;

use App\Models\Point;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PointController extends Controller
{
    public function index()
    {
        $prodis = Mahasiswa::select('prodi')->distinct()->get()->pluck('prodi');
        $angkatans = Mahasiswa::select('angkatan')->distinct()->get()->pluck('angkatan');

        return view('page.ketertiban.point.main', compact('prodis', 'angkatans'));
    }

    public function search(Request $request)
    {
        $query = Mahasiswa::query();

        if ($request->filled('nim')) {
            $query->where('nim', 'like', '%' . $request->nim . '%');
        }

        if ($request->filled('nama')) {
            $query->where('nama', 'like', '%' . $request->nama . '%');
        }

        if ($request->filled('prodi')) {
            $query->where('prodi', $request->prodi);
        }

        if ($request->filled('angkatan')) {
            $query->where('angkatan', $request->angkatan);
        }

        $mahasiswas = $query->get();
        $prodis = Mahasiswa::select('prodi')->distinct()->get()->pluck('prodi');
        $angkatans = Mahasiswa::select('angkatan')->distinct()->get()->pluck('angkatan');

        return view('page.ketertiban.point.main', compact('mahasiswas', 'prodis', 'angkatans'));
    }


    public function detail(Mahasiswa $mahasiswa)
    {
        $points = Point::where('user_id', $mahasiswa->id)->get();
        $akumulasiSkore = $points->sum('points');
        $nilaiHurufPoint = $this->getNilaiHurufPoint($akumulasiSkore);

        return view('page.ketertiban.point.detail-mahasiswa', compact('mahasiswa', 'points', 'akumulasiSkore', 'nilaiHurufPoint'));
    }


    public function create(Mahasiswa $mahasiswa){ 
        return view('page.ketertiban.point.create', ['mahasiswa' => $mahasiswa, 'point' => new Point()]);
    }

    public function store(Request $request, Mahasiswa $mahasiswa)
    {
        $validator = Validator::make($request->all(), [
            'tanggal' => 'required|date',
            'waktu_makan' => 'required|string',
            'points' => 'required|integer',
            'keterangan' => 'required|string',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'alert' => 'error',
                'message' => $validator->errors()->first()
            ]);
        }
    
        $latestPoint = Point::where('user_id', $mahasiswa->id)->orderBy('created_at', 'desc')->first();
    
        $point = new Point;
        $point->user_id = $mahasiswa->id;
        $point->tanggal = $request->tanggal;
        $point->waktu_makan = $request->waktu_makan;
        $point->points = $request->points;
        $point->keterangan = $request->keterangan;
        $point->dibuat = auth()->user()->user_id;
        $point->point_pelanggaran = $latestPoint ? $latestPoint->point_pelanggaran + $request->points : $request->points;
    
        $point->save();
    
        return response()->json([
            'alert' => 'success',
            'message' => 'Pelanggaran berhasil ditambahkan.',
            'redirect_url' => route('point.detail', $mahasiswa->id)
        ]);
    }

    public function edit(Mahasiswa $mahasiswa, Point $point)
    {
        return view('page.ketertiban.point.create', ['mahasiswa' => $mahasiswa, 'point' => $point]);
    }

    public function update(Request $request, Mahasiswa $mahasiswa, Point $point)
    {
        $validator = Validator::make($request->all(), [
            'tanggal' => 'required|date',
            'waktu_makan' => 'required|string',
            'points' => 'required|integer',
            'keterangan' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'alert' => 'error',
                'message' => $validator->errors()->first()
            ]);
        }

        $latestPoint = Point::where('user_id', $mahasiswa->id)->orderBy('created_at', 'desc')->first();

        $point->tanggal = $request->tanggal;
        $point->waktu_makan = $request->waktu_makan;
        $point->points = $request->points;
        $point->keterangan = $request->keterangan;
        $point->dibuat = auth()->user()->user_id;
        $point->point_pelanggaran = $latestPoint ? $latestPoint->point_pelanggaran - $latestPoint->points + $request->points : $request->points;

        $point->save();

        return response()->json([
            'alert' => 'success',
            'message' => 'Pelanggaran berhasil diperbarui.',
            'redirect_url' => route('point.detail', $mahasiswa->id)
        ]);
    }

    public function destroy(Mahasiswa $mahasiswa, Point $point)
    {
        $latestPoint = Point::where('user_id', $mahasiswa->id)->orderBy('created_at', 'desc')->first();

        if ($latestPoint) {
            $point->point_pelanggaran -= $point->points;
            $point->save();
        }

        $point->delete();

        return response()->json([
            'alert' => 'success',
            'message' => 'Pelanggaran berhasil dihapus.', 
        ]);
    }

    private function getNilaiHurufPoint($akumulasiSkore)
    {
        if ($akumulasiSkore >= 85) {
            return 'E';
        } elseif ($akumulasiSkore >= 40) {
            return 'D';
        } elseif ($akumulasiSkore >= 35) {
            return 'C';
        } elseif ($akumulasiSkore >= 10) {
            return 'B';
        } else {
            return 'A';
        }
    }

}
