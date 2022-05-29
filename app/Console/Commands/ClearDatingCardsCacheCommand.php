<?php

namespace App\Console\Commands;

use App\Traits\Cache\CacheKeys;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ClearDatingCardsCacheCommand extends Command
{
    use CacheKeys;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dating-card-cache:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear all cache for dating cards';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        Cache::tags($this->getDatingCardsCacheTag())->flush();

        Log::info('Cache for all dating cards cleared.', ['date' => Carbon::now()->toDateString()]);
    }
}
