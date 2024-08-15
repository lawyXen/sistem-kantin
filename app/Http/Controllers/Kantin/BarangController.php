<?php

namespace App\Http\Controllers\Kantin;

use App\Models\Barang;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DetailBarang;
use Illuminate\Support\Facades\Validator;

class BarangController extends Controller
{
    public function index(Request $request){
        
        $query = Barang::query();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('name', 'LIKE', "%{$search}%");
        }

        $barang = $query->get();

        if ($request->ajax()) {
            return view('page.kantin.barang.list', compact('barang'))->render();
        }

        return view('page.kantin.barang.main', compact('barang')); 
    }

    public function create(){
        return view('page.kantin.barang.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'stock' => 'required',
            'satuan' => 'required',
            'description' => 'required', 
        ]);

        if ($validator->fails()) {
            return response()->json([
                'alert' => 'error',
                'message' => $validator->errors()->first()
            ]);
        } 

        $barang = new Barang();
        $barang->id = Str::random(16);
        $barang->name = $request->name;
        $barang->stock = $request->stock;
        $barang->satuan = $request->satuan;
        $barang->description = $request->description; 
        $barang->save();

        return response()->json([
            'alert' => 'success',
            'message' => 'Barang berhasil ditambahkan.',
            'redirect_url' => route('barang.index')
        ]);
    }
    
    public function edit(Barang $barang)
    {
        return view('page.kantin.barang.create', compact('barang'));
    }

    public function update(Request $request, Barang $barang)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'stock' => 'required',
            'satuan' => 'required',
            'description' => 'required', 
        ]);

        if ($validator->fails()) {
            return response()->json([
                'alert' => 'error',
                'message' => $validator->errors()->first()
            ]);
        }
        
        $detailCount = DetailBarang::where('barang_id', $barang->id)->count();
        if ($detailCount > 0) {
            return response()->json([
                'alert' => 'error',
                'message' => 'Barang tidak dapat diperbarui karena sudah pernah digunakan.'
            ]);
        }
        
        $barang->name = $request->name;
        $barang->stock = $request->stock;
        $barang->satuan = $request->satuan;
        $barang->description = $request->description; 
        $barang->save();

        return response()->json([
            'alert' => 'success',
            'message' => 'Barang berhasil diperbarui.',
            'redirect_url' => route('barang.index')
        ]);
    }

    public function destroy(Barang $barang)
    {
        $barang->delete();

        return response()->json([
            'alert' => 'success',
            'message' => 'Barang berhasil dihapus.',
        ]);
    }

    public function show(Barang $barang)
    {
        $detail = DetailBarang::where('barang_id', $barang->id)
                            ->orderBy('created_at', 'desc')
                            ->get();

        return view('page.kantin.barang.show', compact('barang', 'detail'));
    }

    public function use(Barang $barang)
    {
        return view('page.kantin.barang.use', compact('barang'));
    }

    public function using(Request $request, Barang $barang){
        
        $validator = Validator::make($request->all(), [
            'quantity' => 'required',
            'date' => 'required',
            'status' => 'required', 
            'satuan' => 'required', 
            'detail' => 'required', 
        ]);

        if ($validator->fails()) {
            return response()->json([
                'alert' => 'error',
                'message' => $validator->errors()->first()
            ]);
        }

        if ($request->status == 'Keluar' && $barang->stock < $request->quantity) {
            return response()->json([
                'alert' => 'error',
                'message' => 'Stok Tidak mencukupi',
            ]);
        }

        $detail = new DetailBarang();
        $detail->id = Str::random(16);
        $detail->barang_id = $barang->id;
        $detail->user_id = auth()->user()->user_id;
        $detail->quantity = $request->quantity; 
        $detail->satuan = $request->satuan; 
        $detail->stock = $barang->stock;
        $detail->date = $request->date; 
        $detail->status = $request->status; 
        $detail->detail = $request->detail; 
        $detail->save();

        if ($request->status == 'Keluar') {
            $barang->stock -= $request->quantity;
        } else {
            $barang->stock += $request->quantity;
        }
        $barang->save();

        return response()->json([
            'alert' => 'success',
            'message' => 'Barang berhasil ditambahkan.',
            'redirect_url' => route('barang.show', $barang->id)
        ]);
    }

}