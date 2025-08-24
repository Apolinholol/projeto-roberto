<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory; // <-- importa aqui
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable  
{
    use HasFactory; // <-- adiciona aqui

    protected $fillable = [
        'nomeCompleto',
        'nomeUsuario',
        'email',
        'senha',
        'telefone',
        'cpf',
        'admin'
    ];

    protected $hidden = [
        'senha',
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

    public function setSenhaAttribute($value)
    {
        $this->attributes['senha'] = bcrypt($value);
    }

    public function getAuthPassword()
    {
        return $this->senha;
    }
}
