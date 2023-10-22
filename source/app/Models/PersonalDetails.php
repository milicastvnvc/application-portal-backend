<?php

namespace App\Models;

use App\Enums\BinaryQuestion;
use App\Enums\Gender;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PersonalDetails extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'application_id',
        'surname',
        'fornames',
        'birth_date',
        'birth_place',
        'gender',
        'passport',
        'street',
        'postcode',
        'city',
        'country',
        'telephone',
        'email',
        'alternative_email',
        'disadvantaged'
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

    protected $casts = [
        'gender' => Gender::class,
        'disadvantaged' => BinaryQuestion::class
    ];
}
