<?php

use App\Http\Controllers\Asrama\PicController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Kantin\BarangController;
use App\Http\Controllers\Kantin\KantinController;
use App\Http\Controllers\Mahasiswa\PointController;
use App\Http\Controllers\Utils\MahasiswaController;
use App\Http\Controllers\Utils\CreateUserController;
use App\Http\Controllers\Kantin\PengumumanController;
use App\Http\Controllers\Mahasiswa\ProfileController;
use App\Http\Controllers\Kantin\MenuMakananController;
use App\Http\Controllers\Ketertiban\KantinKetertibanController;
use App\Http\Controllers\Ketertiban\PointController as KetertibanPoint;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['guest.middleware'])->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::get('/', [AuthController::class, 'index'])->name('login.index');
});

Route::post('/do_login', [AuthController::class, 'doLogin'])->name('do_login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['check.token.expiration'])->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard'); 
    Route::get('/dashboard/pengumuman-detail/{pengumuman}', [AuthController::class, 'detail_dashboard'])->name('dashboard.pengumuman_detail'); 
    
    Route::middleware(['check.role:Mahasiswa'])->group(function () {
        Route::get('/pelanggaran', [PointController::class, 'index'])->name('pelanggaran.mahasiswa');  

        Route::get('/profile/{profile}', [ ProfileController::class, 'edit'])->name('profile.mahasiswa'); 
        Route::put('/profile/{profile}/update', [ProfileController::class, 'update'])->name('profile.update');
    });

    Route::middleware(['check.role:SuperAdmin'])->group(function () {
        Route::get('/user', [CreateUserController::class, 'index'])->name('user.index'); 
        Route::post('/user/add-role', [CreateUserController::class, 'addRole'])->name('user.addRole');
        Route::post('/user/remove-role', [CreateUserController::class, 'removeRole'])->name('user.removeRole'); 
        Route::put('/user/{user}', [CreateUserController::class, 'update'])->name('user.update'); 

        Route::get('/mahasiswa', [MahasiswaController::class, 'index'])->name('mahasiswa.index');
        Route::post('/mahasiswa/import', [MahasiswaController::class, 'import'])->name('mahasiswa.import'); 
        Route::get('/mahasiswa/{mahasiswa}', [MahasiswaController::class, 'show'])->name('mahasiswa.show');
        Route::get('/mahasiswa/{mahasiswa}/edit', [MahasiswaController::class, 'edit'])->name('mahasiswa.edit');
        Route::put('/mahasiswa/{mahasiswa}', [MahasiswaController::class, 'update'])->name('mahasiswa.update');
        Route::delete('/mahasiswa/{mahasiswa}', [MahasiswaController::class, 'destroy'])->name('mahasiswa.destroy');
    });

    Route::middleware(['check.role:Kantin,SuperAdmin,Ketertiban,Asrama,Mahasiswa'])->group(function () {
        
        Route::middleware(['check.role:Kantin,SuperAdmin,Mahasiswa'])->group(function () {  

            
            Route::middleware(['check.role:Kantin,SuperAdmin'])->group(function () {  
                Route::get('/menu-makanan/tambah-menu', [MenuMakananController::class, 'create'])->name('menu.create');
                Route::post('/menu-makanan', [MenuMakananController::class, 'store'])->name('menu.store'); 
                Route::get('/menu-makanan/{menu}/edit', [MenuMakananController::class, 'edit'])->name('menu.edit');
                Route::put('/menu-makanan/{menu}', [MenuMakananController::class, 'update'])->name('menu.update');
                Route::delete('/menu-makanan/{menu}', [MenuMakananController::class, 'destroy'])->name('menu.destroy');

                Route::get('/barang', [BarangController::class, 'index'])->name('barang.index'); 
                Route::get('/barang/tambah-barang', [BarangController::class, 'create'])->name('barang.create');
                Route::post('/barang', [BarangController::class, 'store'])->name('barang.store');
                Route::get('/barang/{barang}', [BarangController::class, 'show'])->name('barang.show');
                Route::get('/barang/{barang}/edit', [BarangController::class, 'edit'])->name('barang.edit');
                Route::put('/barang/{barang}', [BarangController::class, 'update'])->name('barang.update');
                Route::delete('/barang/{barang}', [BarangController::class, 'destroy'])->name('barang.destroy');
                Route::get('/barang/{barang}/update-barang', [BarangController::class, 'use'])->name('barang.use');
                Route::post('/barang/{barang}/update-barang', [BarangController::class, 'using'])->name('barang.using');
            });
            Route::get('/menu-makanan', [MenuMakananController::class, 'index'])->name('menu.index');
            
            
        });

        Route::middleware(['check.role:Ketertiban,SuperAdmin,Asrama,Kantin,Mahasiswa'])->group(function () { 
            Route::get('/kantin', [KantinController::class, 'index'])->name('kantin.index'); 
            Route::get('/kantin/{kantin}/detail-kantin', [KantinKetertibanController::class, 'index'])->name('ketertiban.index'); 
            
            Route::middleware(['check.role:Ketertiban,SuperAdmin,Asrama,Kantin'])->group(function () { 
                Route::get('/kantin/tambah-kantin', [KantinController::class, 'create'])->name('kantin.create');
                Route::post('/kantin', [KantinController::class, 'store'])->name('kantin.store'); 
                Route::get('/kantin/{kantin}/edit', [KantinController::class, 'edit'])->name('kantin.edit');
                Route::put('/kantin/{kantin}', [KantinController::class, 'update'])->name('kantin.update');
                Route::delete('/kantin/{kantin}', [KantinController::class, 'destroy'])->name('kantin.destroy');
            });

            Route::middleware(['check.role:Ketertiban,Kantin,SuperAdmin,Asrama'])->group(function () { 
                Route::delete('/kantin/{kantin}/detail-kantin/{detail}', [KantinKetertibanController::class, 'destroy'])->name('ketertiban.destroy'); 
                Route::get('/kantin/{kantin}/tambah-mahasiswa-ke-meja-makan', [KantinKetertibanController::class, 'create'])->name('ketertiban.create');
                Route::post('/kantin/{kantin}/store-mahasiswa', [KantinKetertibanController::class, 'store'])->name('ketertiban.store');
                Route::put('/kantin/{kantin}/update', [KantinKetertibanController::class, 'update'])->name('ketertiban.update');
                
                Route::get('/kantin/{kantin}/detail-kantin/daftar-meja', [KantinKetertibanController::class, 'list_meja'])->name('ketertiban.list_meja'); 
                Route::get('/kantin/{kantin}/tambah-meja', [KantinKetertibanController::class, 'create_meja'])->name('ketertiban.create_meja');
                Route::post('/kantin/{kantin}/store-meja', [KantinKetertibanController::class, 'store_meja'])->name('ketertiban.store_meja');
                Route::get('/kantin/{kantin}/edit-meja/{meja}', [KantinKetertibanController::class, 'edit_meja'])->name('ketertiban.edit_meja');
                Route::put('/kantin/{kantin}/update-meja/{meja}', [KantinKetertibanController::class, 'update_meja'])->name('ketertiban.update_meja');
                Route::delete('/kantin/{kantin}/detail-kantin/{meja}', [KantinKetertibanController::class, 'destroy_meja'])->name('ketertiban.destroy_meja'); 

                Route::get('/kantin/{kantin}/detail-kantin/daftar-piket', [KantinKetertibanController::class, 'piket_index'])->name('ketertiban.piket_index'); 
                Route::post('/kantin/{kantin}/detail-kantin/daftar-piket', [KantinKetertibanController::class, 'piket_store'])->name('ketertiban.piket_store'); 
                Route::post('/kantin/{kantin}/detail-kantin/piket_store_mahasiswa', [KantinKetertibanController::class, 'piket_store_mahasiswa'])->name('ketertiban.piket_store_mahasiswa'); 
                Route::put('/kantin/{kantin}/detail-kantin/update_mahasiswa', [KantinKetertibanController::class, 'update_mahasiswa'])->name('ketertiban.update_mahasiswa');
                Route::delete('/kantin/{kantin}/detail-kantin/{id}/delete_jadwal', [KantinKetertibanController::class, 'delete_jadwal'])->name('ketertiban.delete_jadwal');
                Route::delete('/kantin/{kantin}/detail-kantin/delete_mahasiswa/{id}', [KantinKetertibanController::class, 'delete_mahasiswa'])->name('ketertiban.delete_mahasiswa');
                Route::post('/kantin/{kantin}/detail-kantin/ganti-piket', [KantinKetertibanController::class, 'ganti_piket'])->name('ketertiban.ganti_piket');


                Route::get('/point', [KetertibanPoint::class, 'index'])->name('point.index');
                Route::get('/point/search', [KetertibanPoint::class, 'search'])->name('point.search');
                Route::get('/point/{mahasiswa}/detail', [KetertibanPoint::class, 'detail'])->name('point.detail');
                Route::get('/point/{mahasiswa}/detail/tambah-point', [KetertibanPoint::class, 'create'])->name('point.create');
                Route::post('/point/{mahasiswa}/detail/tambah-point', [KetertibanPoint::class, 'store'])->name('point.store');
                Route::get('/point/{mahasiswa}/detail/edit-point/{point}', [KetertibanPoint::class, 'edit'])->name('point.edit');
                Route::put('/point/{mahasiswa}/detail/edit-point/{point}', [KetertibanPoint::class, 'update'])->name('point.update');
                Route::delete('/point/{mahasiswa}/detail/{point}/delete-point', [KetertibanPoint::class, 'destroy'])->name('point.delete');

            });

        });

        Route::middleware(['check.role:Ketertiban,Kantin,SuperAdmin,Asrama'])->group(function () {
            Route::get('/kantin/pic-keasramaan/{kantin}', [PicController::class, 'index'])->name('asrama.index');
            Route::get('/kantin/pic-keasramaan/{kantin}/tambah-jadwal', [PicController::class, 'create'])->name('asrama.create');
            Route::post('kantin/pic-keasramaan/store/{kantin}', [PicController::class, 'store'])->name('asrama.store');
            Route::delete('kantin/pic-keasramaan/{pic}', [PicController::class, 'destroy'])->name('asrama.destroy');
        }); 
    
        Route::get('/pengumuman', [PengumumanController::class, 'index'])->name('pengumuman.index');
        Route::get('/pengumuman/tambah-pengumuman', [PengumumanController::class, 'create'])->name('pengumuman.create');
        Route::post('/pengumuman', [PengumumanController::class, 'store'])->name('pengumuman.store');
        Route::get('/pengumuman/{pengumuman}', [PengumumanController::class, 'show'])->name('pengumuman.show');
        Route::get('/pengumuman/{pengumuman}/edit', [PengumumanController::class, 'edit'])->name('pengumuman.edit');
        Route::put('/pengumuman/{pengumuman}', [PengumumanController::class, 'update'])->name('pengumuman.update');
        Route::delete('/pengumuman/{pengumuman}', [PengumumanController::class, 'destroy'])->name('pengumuman.destroy');
    });
});
