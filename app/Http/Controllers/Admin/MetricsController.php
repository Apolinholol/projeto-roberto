<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Ads;
use App\Models\Chat;
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

        // Mapeamento de chaves para labels legíveis
        $reasonLabels = [
            'SOLD_HERE' => 'Vendido com sucesso neste chat',
            'SOLD_ELSEWHERE' => 'Vendido por outro meio',
            'SALE_CANCELLED' => 'Desisti da venda',
            'BUYER_ISSUE' => 'Problemas com o comprador',
            'OTHER' => 'Prefiro não dizer',
        ];

        $finalizationReasons = Chat::whereNotNull('finalization_reason')
            ->select('finalization_reason', DB::raw('count(*) as count'))
            ->groupBy('finalization_reason')
            ->get()
            ->map(function ($item) use ($reasonLabels) {
                return [
                    'reason' => $reasonLabels[$item->finalization_reason] ?? $item->finalization_reason,
                    'count' => $item->count,
                ];
            });

        $totalFinalized = $finalizationReasons->sum('count');


        return Inertia::render('Admin/Metrics/index', [
            'metrics' => [
                'adsCreatedToday' => $adsCreatedToday,
                'usersCreatedToday' => $usersCreatedToday,
                'adsByCategory' => $adsByCategory,
                'adsStatusData' => $adsStatusData,
                'totalAds' => $activeAds + $inactiveAds,
                'totalCategories' => Category::count(),
                'totalUsers' => User::count(),
                'finalizationReasons' => $finalizationReasons,
                'totalFinalized' => $totalFinalized,
            ]
        ]);
    }
}
