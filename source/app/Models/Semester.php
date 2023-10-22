<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Semester extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name'
    ];

    protected $hidden = [
        'is_active',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function proposed_host_universities()
    {
        return $this->hasMany(ProposedHostUniversities::class);
    }

}
