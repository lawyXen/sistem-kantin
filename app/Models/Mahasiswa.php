<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mahasiswa extends Model
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
        'nama', 
        'nim',
        'prodi',
        'angkatan',
        'username',
        'email',
    ];

    public function detailPikets()
    {
        return $this->hasMany(DetailPiket::class, 'user_id', 'id');
    }

    public function detailMeja()
    {
        return $this->hasMany(DetailMeja::class, 'user_id', 'id');
    }
}