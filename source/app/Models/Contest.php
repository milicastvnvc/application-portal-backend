<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contest extends Model
{
    use HasFactory;
    protected $fillable = ['contest_name', 'start_date', 'end_date'];

    public function applications()
    {
        return $this->hasMany(Application::class);
    }
}
