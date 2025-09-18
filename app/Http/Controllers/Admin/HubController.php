<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Ad;
use App\Models\Category;

class HubController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Hub', [
            'stats' => [
                'users' => User::count(),
                'ads' => Ad::count(),
                'categories' => Category::count()
            ],
        ]);
    }
}
