<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Anuncio extends Model
{
    protected $fillable = [
        'user_id',
        'titulo',
        'descricao',
        'preco',
        'dataCriacao',
        'ativo',
        'imagem',
        'anunciante' 
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function categoria(): BelongsTo{
        return $this->belongsTo(Categoria::Class);
    }
}
