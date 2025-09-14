<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        $ufs = [
            'AC','AL','AP','AM','BA','CE','DF','ES','GO','MA',
            'MT','MS','MG','PA','PB','PR','PE','PI','RJ',
            'RN','RS','RO','RR','SC','SP','SE','TO'
        ];

        return [
            'nomeCompleto' => fake('pt_BR')->name(),
            'nomeUsuario' => fake()->unique()->userName(),
            'email' => fake()->unique()->safeEmail(),
            'password' => 'password', 
            'cidade' => fake('pt_BR')->city(),
            'uf' => fake()->randomElement($ufs),
            'telefone' => fake('pt_BR')->phoneNumber(),
            'cpf' => fake('pt_BR')->unique()->cpf(false), 
            'admin' => false,
            'remember_token' => Str::random(10),
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
