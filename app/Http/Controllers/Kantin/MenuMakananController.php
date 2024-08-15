<?php

namespace App\Http\Controllers\Kantin;

use Carbon\Carbon;
use App\Models\Menu;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class MenuMakananController extends Controller
{
    public function index(Request $request)
    {
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfNextWeek = Carbon::now()->addWeek()->endOfWeek();

        $menu = Menu::whereBetween('created_at', [$startOfWeek, $endOfNextWeek])->get();

        return view('page.kantin.menu.main', compact('menu'));
    }

    public function create()
    {
        return view('page.kantin.menu.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tanggal' => 'required|date',
            'menu_pagi_makanan' => 'required|string',
            'status_pagi' => 'nullable|string',
            'menu_siang_makanan' => 'required|string',
            'status_siang' => 'nullable|string',
            'menu_malam_makanan' => 'required|string',
            'status_malam' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'alert' => 'error',
                'message' => $validator->errors()->first()
            ]);
        }

        // Cek apakah sudah ada menu pada tanggal yang sama
        $existingMenu = Menu::whereDate('tanggal', $request->tanggal)->first();
        if ($existingMenu) {
            return response()->json([
                'alert' => 'error',
                'message' => 'Menu untuk tanggal ini sudah ada.'
            ]);
        } 

        $menu = new Menu();
        $menu->id = Str::random(16);
        $menu->tanggal = $request->tanggal;
        $menu->menu_sarapan = $request->menu_pagi_makanan;
        $menu->status_sarapan = $request->status_pagi;
        $menu->menu_siang = $request->menu_siang_makanan;
        $menu->status_siang = $request->status_siang;
        $menu->menu_malam = $request->menu_malam_makanan;
        $menu->status_malam = $request->status_malam;
        $menu->save();

        return response()->json([
            'alert' => 'success',
            'message' => 'Menu berhasil ditambahkan.',
            'redirect_url' => route('menu.index')
        ]);
    }

    public function edit(Menu $menu)
    {
        return view('page.kantin.menu.create', compact('menu'));
    }

    public function update(Request $request, Menu $menu)
    {
        $validator = Validator::make($request->all(), [
            'tanggal' => 'required|date',
            'menu_pagi_makanan' => 'required|string',
            'status_pagi' => 'nullable|string',
            'menu_siang_makanan' => 'required|string',
            'status_siang' => 'nullable|string',
            'menu_malam_makanan' => 'required|string',
            'status_malam' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'alert' => 'error',
                'message' => $validator->errors()->first()
            ]);
        }

        // Cek apakah sudah ada menu pada tanggal yang sama kecuali menu ini
        $existingMenu = Menu::whereDate('created_at', $request->tanggal)->where('id', '!=', $menu->id)->first();
        if ($existingMenu) {
            return response()->json([
                'alert' => 'error',
                'message' => 'Menu untuk tanggal ini sudah ada.'
            ]);
        }

        $menu->created_at = $request->tanggal;
        $menu->menu_sarapan = $request->menu_pagi_makanan;
        $menu->status_sarapan = $request->status_pagi;
        $menu->menu_siang = $request->menu_siang_makanan;
        $menu->status_siang = $request->status_siang;
        $menu->menu_malam = $request->menu_malam_makanan;
        $menu->status_malam = $request->status_malam;
        $menu->save();

        return response()->json([
            'alert' => 'success',
            'message' => 'Menu berhasil diperbarui.',
            'redirect_url' => route('menu.index')
        ]);
    }

    public function destroy(Menu $menu)
    {
        $menu->delete(); 
        return response()->json([
            'alert' => 'success',
            'message' => 'Menu berhasil dihapus.', 
        ]);
    }
}
