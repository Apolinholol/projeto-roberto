<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'nomeCompleto',
        'nomeUsuario',
        'email',
        'password', // campo no banco
        'telefone',
        'cpf',
        'is_active',
        'admin'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function enderecos(): HasMany
    {
        return $this->hasMany(Endereco::class);
    }

    public function anuncios(): HasMany
    {
        return $this->hasMany(Anuncio::class, 'user_id');
    }

    public function chatsAsBuyer(): HasMany
    {
        return $this->hasMany(Chat::class, 'id_comprador');
    }

    public function chatsAsSeller(): HasMany
    {
        return $this->hasMany(Chat::class, 'id_vendedor');
    }
}