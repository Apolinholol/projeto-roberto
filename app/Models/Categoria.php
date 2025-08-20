<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Categoria extends Model
{
    protected $fillable = ['nome'];

    public function anuncio(): HasMany
    {
        return $this->hasMany(Anuncio::class);
    }
}
