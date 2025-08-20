<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Endereco extends Model
{
    protected $fillable = [
        'user_id',
        'rua',
        'numero',
        'cidade',
        'estado',
        'cep'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
