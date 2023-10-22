<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class UnlockedForm extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'application_id',
        'form_name'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];


    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

}
