<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HomeInstitutionForm extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'application_id',
        'faculty',
        'department',
        'current_grade',
        'previous_gpa',
        'study_program',
        'responsible_person',
        'email_responsible_person',
        'other_contact'
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
