<?php

namespace App\Http\Controllers\Storage;

use App\Jobs\StoreLog;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LogController extends Controller
{
    public function index()
    {
        $user = User::find(1);
        $user2 = User::find(2);

        $job = (new StoreLog($user))->onQueue('A');
        $job2 = (new StoreLog($user2))->onQueue('B');

        dispatch($job);
        dispatch($job2);
    }
}
