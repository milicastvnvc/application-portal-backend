<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DocumentsUpload extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'application_id',
        'passport',
        'candidate_photograph',
        'europass',
        'previous_diplomas',
        'foreign_language_proficiency'
    ];

    protected $hidden = [
        'deleted_at'
    ];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }
}
