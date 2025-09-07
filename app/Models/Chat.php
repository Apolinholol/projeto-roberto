<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Chat extends Model
{

    public function buyer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_comprador');
    }

    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_vendedor');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }
}