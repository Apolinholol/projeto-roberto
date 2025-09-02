<?php

use App\Models\User;

$users = User::all();

echo "=== USUÁRIOS REGISTRADOS ===\n";
echo "Total: " . $users->count() . " usuários\n\n";

foreach ($users as $user) {
    echo "ID: {$user->id}\n";
    echo "Nome: {$user->nomeCompleto}\n";
    echo "Email: {$user->email}\n";
    echo "Admin: " . ($user->admin ? 'Sim' : 'Não') . "\n";
    echo "Criado em: {$user->created_at}\n";
    echo "-------------------\n";
}
