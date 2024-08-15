<?php

namespace App\Models;

use App\Models\User;
use App\Models\Mahasiswa;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Point extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = Str::random(16);
            }
        });
    }

    protected $fillable = [
        'id', 
        'user_id', 
        'tanggal', 
        'waktu_makan', 
        'dibuat', 
        'points', 
        'point_pelanggaran', 
        'keterangan'
    ];
    
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'user_id', 'id');
    } 

    public function user()
    {
        return $this->belongsTo(User::class, 'dibuat', 'user_id');
    }
    
}
