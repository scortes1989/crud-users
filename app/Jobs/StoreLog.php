<?php

namespace App\Jobs;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

class StoreLog implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info('enviando mensaje a '.$this->user->name.' a las '.Carbon::now()->format('d/m/Y H:i:s'));
        Log::info('enviando mensaje a '.$this->user->name.' a las '.Carbon::now()->format('d/m/Y H:i:s'));
        Log::info('enviando mensaje a '.$this->user->name.' a las '.Carbon::now()->format('d/m/Y H:i:s'));
        Log::info('enviando mensaje a '.$this->user->name.' a las '.Carbon::now()->format('d/m/Y H:i:s'));
        Log::info('enviando mensaje a '.$this->user->name.' a las '.Carbon::now()->format('d/m/Y H:i:s'));
    }
}
