<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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

    public function application()
    {
        return $this->belongsTo(Application::class);
    }
}
