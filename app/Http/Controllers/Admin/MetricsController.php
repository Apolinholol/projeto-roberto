<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Ads;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MetricsController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $adsCreatedToday = Ads::whereDate('created_at', $today)->count();
        $usersCreatedToday = User::whereDate('created_at', $today)->count();

        $adsByCategory = Category::withCount('ads')
            ->get()
            ->map(function ($category) {
                return [
                    'name' => $category->name,
                    'count' => $category->ads_count
                ];
            });

        $activeAds = Ads::where('is_active', true)->count();
        $inactiveAds = Ads::where('is_active', false)->count();

        $adsStatusData = [
            ['status' => 'Ativos', 'count' => $activeAds],
            ['status' => 'Inativos', 'count' => $inactiveAds]
        ];

        return Inertia::render('Admin/Metrics/index', [
            'metrics' => [
                'adsCreatedToday' => $adsCreatedToday,
                'usersCreatedToday' => $usersCreatedToday,
                'adsByCategory' => $adsByCategory,
                'adsStatusData' => $adsStatusData,
                'totalAds' => $activeAds + $inactiveAds,
                'totalCategories' => Category::count(),
                'totalUsers' => User::count()
            ]
        ]);
    }
}
