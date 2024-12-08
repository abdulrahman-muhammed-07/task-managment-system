<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\IStatisticRepository;

class StatisticController extends Controller
{
    public function index(IStatisticRepository $statisticRepository)
    {
        $statistics = $statisticRepository->withRelations(['user:id,name'])->topStatistics(10);

        return view('statistics.index', compact('statistics'));
    }
}
