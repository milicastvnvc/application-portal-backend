<?php

namespace App\Models;

use App\Enums\FormProgress;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApplicationProgress extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'application_id',
        'personal_details',
        'home_institution',
        'proposed_host_universities',
        'motivation_and_added_value',
        'documents_upload'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $casts = [
        'personal_details' => FormProgress::class,
        'home_institution' => FormProgress::class,
        'proposed_host_universities' => FormProgress::class,
        'motivation_and_added_value' => FormProgress::class,
        'documents_upload' => FormProgress::class
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }
}
