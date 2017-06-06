<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SendMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sendmails {--message=prueba}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envia ofertas';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $users = User::orderBy('name')->get();

        foreach($users as $user) {
            Log::info($this->option('message'));
        }
    }
}
