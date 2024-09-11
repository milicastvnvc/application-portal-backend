<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Call extends Model
{
    use HasFactory;

    protected $fillable = ['call_name', 'start_date', 'end_date'];

    public function applications()
    {
        return $this->hasMany(Application::class);
    }
}
