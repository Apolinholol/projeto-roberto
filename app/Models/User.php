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
        'senha', // campo no banco
        'telefone',
        'cpf',
        'is_active',
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

    public function chatsAsBuyer(): HasMany
    {
        return $this->hasMany(Chat::class, 'id_comprador');
    }

    public function chatsAsSeller(): HasMany
    {
        return $this->hasMany(Chat::class, 'id_vendedor');
    }



    // Hash automático ao criar ou alterar senha
    public function setSenhaAttribute($value)
    {
        if (!empty($value) && !Hash::needsRehash($value)) {
            $this->attributes['senha'] = bcrypt($value);
        } else {
            $this->attributes['senha'] = $value; // já é hash
        }
    }
    // Diz ao Laravel que o campo de senha é "senha" e não "password"
    public function getAuthPassword()
    {
        return $this->senha;
    }
}