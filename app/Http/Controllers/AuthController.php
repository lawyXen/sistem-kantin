<?php

namespace App\Http\Controllers;

use App\Models\DetailMeja;
use App\Models\DetailPiket;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Point;
use App\Models\Mahasiswa;
use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function index(){
        return view('welcome');
    }

    public function doLogin(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'alert' => 'error',
                'message' => $validator->errors()->first()
            ]);
        }  

        try {
            $response = Http::asForm()->post(env('BASE_URL') . '/jwt-api/do-auth', [
                'username' => $request->username,
                'password' => $request->password
            ]);

            $responseBody = $response->json();

            if ($responseBody['result']) {
                $token = $responseBody['token']; 

                try { 
                    $tokenParts = explode('.', $token);
                    $tokenPayload = json_decode(base64_decode($tokenParts[1]));
                    
                    if (!$tokenPayload) {
                        throw new \Exception("Invalid token payload");
                    }

                    $expiresAt = null;
                    if (isset($tokenPayload->exp)) {
                        if (!ctype_digit($tokenPayload->exp)) {
                            $tokenPayload->exp = strtotime($tokenPayload->exp);
                        }
                        $expiresAt = Carbon::createFromTimestamp($tokenPayload->exp)->setTimezone('Asia/Jakarta');
                        $expiresAtFormatted = $expiresAt->format('Y-m-d H:i:s');
                    } else {
                        throw new \Exception("Token expiration time not found");
                    }  
                    
                    $user = User::where('user_id', $responseBody['user']['user_id'])->first();
                    if ($user) {
                        // Update hanya jabatan, token, dan token_expires_at
                        $user->jabatan = $responseBody['user']['jabatan'] ?? null;
                        $user->token = $token;
                        $user->token_expires_at = $expiresAtFormatted; 
                        $user->save();
                    } else {
                        $role = is_array($responseBody['user']['role']) ? $responseBody['user']['role'] : [$responseBody['user']['role']];
                        $user = new User([
                            'user_id' => $responseBody['user']['user_id'],
                            'username' => $responseBody['user']['username'],
                            'email' => $responseBody['user']['email'],
                            'role' => json_encode($role), // Ensure role is saved as JSON
                            'status' => $responseBody['user']['status'],
                            'jabatan' => $responseBody['user']['jabatan'] ?? null,
                            'token' => $token,
                            'token_expires_at' => $expiresAtFormatted
                        ]);
                        $user->save();
                    }

                    // Tambahkan data ke tabel mahasiswa jika role adalah Mahasiswa
                    $role = is_array($responseBody['user']['role']) ? $responseBody['user']['role'] : [$responseBody['user']['role']];
                    if (in_array('Mahasiswa', $role)) {
                        $existingMahasiswa = Mahasiswa::where('nim', $responseBody['user']['username'])->first();
                        if (!$existingMahasiswa) {
                            Mahasiswa::create([
                                'nama' => $responseBody['user']['username'],
                                'nim' => $responseBody['user']['username'], //tergantung kepada api
                                'prodi' => $responseBody['user']['email'],
                                'angkatan' => $responseBody['user']['email'],
                                'username' => $responseBody['user']['username'],
                                'email' => $responseBody['user']['email']
                            ]);
                        }
                    }
                    
                    Auth::login($user);
                    
                    return response()->json([
                        'alert' => 'success',
                        'message' => 'Selamat Datang Kembali '.$responseBody['user']['username'],
                        'redirect_url' => '/dashboard'
                    ]);
                } catch (\Exception $e) {
                    Log::error('Database Query Exception: ' . $e->getMessage());
                    return response()->json([
                        'alert' => 'error',
                        'message' => $e->getMessage()
                    ]);
                }
            } else {
                // Pengecekan ke database lokal jika login API gagal
                $user = User::where('username', $request->username)->first();
                if ($user && Hash::check($request->password, $user->password)) {
                    Auth::login($user);
                    return response()->json([
                        'alert' => 'success',
                        'message' => 'Selamat Datang Kembali '.$user->username,
                        'redirect_url' => '/dashboard'
                    ]);
                } else {
                    return response()->json([
                        'alert' => 'error',
                        'message' => 'Username atau password salah.'
                    ]);
                }
            }
        } catch (\Exception $e) {
            return response()->json([
                'alert' => 'error',
                'message' => 'Username atau Password Salah'
            ]);
        }
    }



    public function logout(Request $request)
    {
        Auth::logout();
        
        return response()->json([
            'alert' => 'success',
            'message' => 'Logout berhasil.',
            'redirect_url' => '/'
        ]);
    }

    public function dashboard()
    {
        $pengumuman = Pengumuman::orderBy('created_at', 'desc')->take(10)->get();
        
        $auth = Auth::user()->username; 

        $mahasiswa = Mahasiswa::where('username', $auth)->first();

        $mejaDetailLainnya = collect(); // Default to empty collection
        $detailMeja = null;
        if ($mahasiswa) {
            $detailMeja = DetailMeja::where('user_id', $mahasiswa->id)->first();
            if ($detailMeja) {
                $meja_id = $detailMeja->meja_id;
                $mejaDetailLainnya = DetailMeja::where('meja_id', $meja_id)->get();
            }
        }

        $piketLainnya = collect(); // Default to empty collection
        $detailPiket = null;
        if ($mahasiswa) {
            $detailPiket = DetailPiket::where('user_id', $mahasiswa->id)->first();
            if ($detailPiket) {
                $piket_id = $detailPiket->piket_id;
                $piketLainnya = DetailPiket::where('piket_id', $piket_id)->get();
            }
        }
        
        return view('page.dashboard', compact('pengumuman', 'mejaDetailLainnya', 'detailMeja', 'detailPiket', 'piketLainnya'));
    }

    

    public function detail_dashboard(Pengumuman $pengumuman) {
        return view('page.detail_pengumuman', compact('pengumuman'));
    }
}