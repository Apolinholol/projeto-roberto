<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Show the registration page.
     */
    public function create(): Response
    {
        return Inertia::render('auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nomeCompleto' => 'required|string|max:255',
            'nomeUsuario' => 'required|string|max:255|unique:users,nomeUsuario',
            'email' => 'required|string|lowercase|email|max:255|unique:users,email',
            'senha' => 'required|string|min:8|confirmed',
            'telefone' => 'nullable|string|max:20',
            'cpf' => 'required|string|max:14|unique:users,cpf',
        ]);

        $user = User::create([
            'nomeCompleto' => $request->nomeCompleto,
            'nomeUsuario' => $request->nomeUsuario,
            'telefone' => $request->telefone,
            'cpf' => $request->cpf,
            'email' => $request->email,
            'senha' => Hash::make($request->senha),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return to_route('home');
    }
}
