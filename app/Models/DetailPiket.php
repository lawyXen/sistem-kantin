<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPiket extends Model
{
    use HasFactory;

    protected $table = 'detail_pikets';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'piket_id',
        'user_id',
    ];

    public function piket()
    {
        return $this->belongsTo(Piket::class, 'piket_id', 'id');
    }

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'user_id', 'id');
    }
}
