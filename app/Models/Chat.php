<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Chat extends Model
{
    protected $fillable = [
        'id_comprador',
        'id_vendedor',
        'ad_id',
        'finalizado',
    ];

    protected static function booted(): void
    {
        static::created(function (Chat $chat) {
            Message::create([
                'chat_id' => $chat->id,
                'user_id' => null, // Mensagem do sistema, sem usuário específico
                'content' => 'Não nos responsabilizamos por nenhuma negociação feita na plataforma. Utilize a plataforma com cautela.',
                'system_message' => true,
            ]);
        });
    }

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

    public function ad(): BelongsTo
    {
        return $this->belongsTo(Ad::class);
    }
}
