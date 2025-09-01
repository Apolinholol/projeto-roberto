<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ad;
use App\Models\User;
use App\Models\Category;
use Faker\Factory as Faker;

class AdsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('pt_BR');
        
        // Pega todos os usuários existentes
        $users = User::all();
        
        if ($users->isEmpty()) {
            // Se não houver usuários, cria um usuário padrão com os campos corretos
            $user = User::create([
                'nomeCompleto' => 'Usuário Teste',
                'nomeUsuario' => 'teste_usuario',
                'email' => 'teste@vendiff.com',
                'senha' => bcrypt('password'),
                'cpf' => '11111111111',
                'telefone' => '11999999999',
            ]);
            $users = collect([$user]);
        }

        $categorias = Category::all();
        
        if ($categorias->isEmpty()) {
            // Se não houver categorias, cria algumas
            $categoria1 = Category::create(['name' => 'Eletrônicos']);
            $categoria2 = Category::create(['name' => 'Automotivos']);
            $categoria3 = Category::create(['name' => 'Literatura']);
            $categorias = collect([$categoria1, $categoria2, $categoria3]);
        }

        // Criar 50 anúncios de exemplo
        for ($i = 0; $i < 50; $i++) {
            Ad::create([
                'name' => $faker->sentence(3),
                'description' => $faker->paragraph(3),
                'price' => $faker->randomFloat(2, 10, 5000),
                'stock' => $faker->numberBetween(1, 100),
                'category_id' => $categorias->random()->id,
            ]);
        }
    }
}