<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pengumuman extends Model
{
    use HasFactory;

    protected $table = 'pengumuman';

    protected $fillable = [
        'id',
        'tanggal_pengumuman',
        'topik_pengumuman',
        'user_id',
        'deskripsi'
    ];

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
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
