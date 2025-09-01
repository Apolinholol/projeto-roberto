<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class ListUsers extends Command
{
    protected $signature = 'users:list';
    protected $description = 'Lista todos os usuários registrados';

    public function handle()
    {
        $users = User::all();
        
        $this->info('=== USUÁRIOS REGISTRADOS ===');
        $this->info('Total: ' . $users->count() . ' usuários');
        $this->newLine();

        foreach ($users as $user) {
            $this->info("ID: {$user->id}");
            $this->info("Nome: {$user->nomeCompleto}");
            $this->info("Usuário: {$user->nomeUsuario}");
            $this->info("Email: {$user->email}");
            $this->info("Admin: " . ($user->admin ? 'Sim' : 'Não'));
            $this->info("CPF: {$user->cpf}");
            $this->info("Telefone: " . ($user->telefone ?? 'Não informado'));
            $this->info("Criado em: {$user->created_at}");
            $this->info('-------------------');
        }

        return 0;
    }
}
