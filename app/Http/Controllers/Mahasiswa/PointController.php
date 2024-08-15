<?php

namespace App\Http\Controllers\Mahasiswa;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use App\Models\Point;
use Illuminate\Support\Facades\Auth;

class PointController extends Controller
{
    public function index() { 
        $auth = Auth::user()->username; 

        $mahasiswa = Mahasiswa::where('username', $auth)->first();

        $point = Point::where('user_id', $mahasiswa->id)->get(); 
        
        return view('page.mahasiswa.point', compact('point'));
    }
}