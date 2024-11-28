<?php

namespace App\Jobs;

use App\Models\Statistic;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class UpdateStatisticsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(protected $id)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $statistic = Statistic::updateOrCreate([
            'user_id' => $this->id,
        ], [
            'task_count' => DB::raw('task_count + 1'),
        ]);
        //  Update statistics SET task_count = task_count + 1 WHERE user_id = 1;
        // $statistic->increment('task_count', 1);
    }
}
