<?php

namespace App\Models;

use App\Enums\BinaryQuestion;
use App\Enums\Gender;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
        'disadvantaged',
        'previous_participation',
        'participation_count',
        'name_of_host_institution_1',
        'mobility_date_1',
        'name_of_host_institution_2',
        'mobility_date_2',
        'name_of_host_institution_3',
        'mobility_date_3',
        'name_of_host_institution_4',
        'mobility_date_4',
        'name_of_host_institution_5',
        'mobility_date_5'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $casts = [
        'gender' => Gender::class,
        'disadvantaged' => BinaryQuestion::class
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }
}
