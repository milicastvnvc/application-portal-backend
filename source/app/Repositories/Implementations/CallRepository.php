<?php

namespace App\Repositories\Implementations;

use App\Models\Call;
use App\Repositories\Interfaces\ICallRepository;

class CallRepository implements ICallRepository
{
    public function getLatestCall()
    {
        return Call::orderBy('start_date', 'desc')->first(); // Fetch the latest call based on deadline or created_at
    }
}
