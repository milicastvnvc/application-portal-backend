<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Application extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'mobility_id',
        'home_institution_id',
        'submitted_at'
    ];

    protected $hidden = [
        'updated_at',
        'deleted_at'
    ];

    protected $casts = [
        'submitted_at' => 'datetime'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function home_institution(): BelongsTo
    {
        return $this->belongsTo(HomeInstitution::class);
    }

    public function mobility(): BelongsTo
    {
        return $this->belongsTo(Mobility::class);
    }

    public function other_mobility()
    {
        return $this->hasOne(OtherMobility::class);
    }

    public function application_progress()
    {
        return $this->hasOne(ApplicationProgress::class);
    }

    public function personal_details()
    {
        return $this->hasOne(PersonalDetails::class);
    }

    public function home_institution_form()
    {
        return $this->hasOne(HomeInstitutionForm::class);
    }

    public function proposed_host_universities()
    {
        return $this->hasOne(ProposedHostUniversities::class);
    }

    public function motivation_and_added_value()
    {
        return $this->hasOne(MotivationAndAddedValue::class);
    }

    public function documents_upload()
    {
        return $this->hasOne(DocumentsUpload::class);
    }

    public function unlocked_forms()
    {
        return $this->hasMany(UnlockedForm::class);
    }
}
