<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class MobilitiesDocumentTypes extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'document_type_id',
        'mobility_type'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function document_type(): BelongsTo
    {
        return $this->belongsTo(DocumentType::class);
    }
}
