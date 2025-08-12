<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HubController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Hub', [
            'stats' => [
                'users' => User::count(),
                'products' => Product::count(),
            ],
        ]);
    }
}
