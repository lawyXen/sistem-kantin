<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menu extends Model
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
        'tanggal',
        'menu_sarapan',
        'menu_siang',
        'menu_malam',
        'status_sarapan',
        'status_siang',
        'status_sarapan',
    ];
}
