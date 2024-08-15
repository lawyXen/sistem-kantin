<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Piket extends Model
{
    use HasFactory;

    protected $table = 'pikets';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'kantin_id',
        'nama_piket',
        'active',
    ];

    public function kantin()
    {
        return $this->belongsTo(Kantin::class, 'kantin_id', 'id');
    }

    public function detailPikets()
    {
        return $this->hasMany(DetailPiket::class, 'piket_id', 'id');
    }
}