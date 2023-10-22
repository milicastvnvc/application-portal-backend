<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UploadedDocument extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'application_id',
        'document_type_id',
        'path',
        'filename'
    ];

    protected $hidden = [
        'deleted_at'
    ];

    public function document_type()
    {
        return $this->belongsTo(DocumentType::class);
    }
}
