<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class DeleteAllUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:delete-all {--force : Força a exclusão sem confirmação}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deleta todos os usuários do banco de dados';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::all();
        $totalUsers = $users->count();

        if ($totalUsers === 0) {
            $this->info('Nenhum usuário encontrado no banco de dados.');
            return 0;
        }

        $this->warn("⚠️  ATENÇÃO: Esta ação irá deletar TODOS os {$totalUsers} usuários do banco de dados!");
        
        if (!$this->option('force')) {
            $confirmed = $this->confirm('Tem certeza que deseja prosseguir?');
            if (!$confirmed) {
                $this->info('Operação cancelada.');
                return 0;
            }
        }

        $this->info('Deletando usuários...');
        
        $bar = $this->output->createProgressBar($totalUsers);
        $bar->start();

        foreach ($users as $user) {
            $user->delete();
            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);
        
        $this->info("✅ Todos os {$totalUsers} usuários foram deletados com sucesso!");
        
        return 0;
    }
}
