<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailMeja extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'kantin_id',
        'user_id',
        'meja_id',
    ];

    public function mejaMakan()
    {
        return $this->belongsTo(MejaMakan::class, 'meja_id');
    }

    public function kantin()
    {
        return $this->belongsTo(Kantin::class, 'kantin_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'user_id', 'id');
    }
}
