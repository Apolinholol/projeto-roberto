<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('nomeUsuario', 'like', "%{$search}%");
        }

        $users = $query->paginate(10);

        return Inertia::render('Admin/User/Index', [
            'users' => $users->through(function ($user) {
                return [
                    'id' => $user->id,
                    'nameCompleto' => $user->nameCompleto,
                    'nomeUsuario' => $user->nomeUsuario,
                    'email' => $user->email,
                    'telefone' => $user->telefone,
                    'cpf' => $user->cpf,
                    'cidade' => $user->cidade,
                    'uf' => $user->uf,
                    'is_active' => $user->is_active,
                    'created_at' => $user->created_at->toFormattedDateString(),
                ];
            }),
            'filters' => $request->only(['search']),
        ]);
    }

    public function toggleStatus(Request $request, User $user)
    {
        $request->validate([
            'is_active' => 'required|boolean',
        ]);

        $user->is_active = $request->is_active;
        $user->save();

        return redirect()->back();
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->back();
    }
}
