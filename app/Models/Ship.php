<?php

namespace App\Models;

use App\Services\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ship extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $appends = [
        'foto_kapal_url',
        'dokumen_perizinan_url',
        'status',
    ];

    protected function fotoKapalUrl(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => isset($attributes['foto_kapal_url'])
                ? File::show($attributes['foto_kapal_url'])
                : null,
        );
    }

    protected function dokumenPerizinanUrl(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => isset($attributes['dokumen_perizinan_url'])
                ? File::show($attributes['dokumen_perizinan_url'])
                : null,
        );
    }

    protected function status(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => isset($attributes['is_verified'])
                ? 'Kapal Layak Berlayar'
                : 'Kapal Tidak Layak Berlayar',
        );
    }
}
