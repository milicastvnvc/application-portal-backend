<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class DocumentType extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'is_required',
        'file_formats'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function uploaded_documents(): HasMany
    {
        return $this->hasMany(UploadedDocument::class);
    }

    public function mobility_types(): HasMany
    {
        return $this->hasMany(MobilitiesDocumentTypes::class);
    }

    public function links(): HasMany
    {
        return $this->hasMany(DocumentTypeLink::class);
    }
}
