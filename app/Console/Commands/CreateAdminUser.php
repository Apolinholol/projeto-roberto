<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new admin user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->ask('Enter the full name');
        $username = $this->ask('Enter the username (nomeUsuario)');
        $email = $this->ask('Enter the email');
        $password = $this->secret('Enter the password');
        $city = $this->ask('Enter the city (cidade)');
        $state = $this->ask('Enter the state (uf)');
        $cpf = $this->ask('Enter the CPF');

        $validator = Validator::make([
            'name' => $name,
            'username' => $username,
            'email' => $email,
            'password' => $password,
            'city' => $city,
            'state' => $state,
            'cpf' => $cpf,
        ], [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,nomeUsuario'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'city' => ['required', 'string', 'max:255'],
            'state' => ['required', 'string', 'max:2'],
            'cpf' => ['required', 'string', 'max:14', 'unique:users,cpf'],
        ]);

        if ($validator->fails()) {
            $this->info('Admin user not created. See error messages below:');

            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }
            return 1;
        }

        $user = User::create([
            'nomeCompleto' => $name,
            'nomeUsuario' => $username,
            'email' => $email,
            'password' => Hash::make($password),
            'cidade' => $city,
            'uf' => $state,
            'cpf' => $cpf,
            'image_path' => null,
            'admin' => true,
            'is_active' => true,
        ]);

        $this->info('Admin user created successfully!');
        $this->info("Name: {$user->nomeCompleto}");
        $this->info("Username: {$user->nomeUsuario}");
        $this->info("Email: {$user->email}");

        return 0;
    }
}
