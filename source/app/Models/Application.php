<?php

namespace App\Models;

use App\Enums\ApplicationStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Application extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'mobility_id',
        'home_institution_id',
        'status',
        'submitted_at'
    ];

    protected $hidden = [
        'updated_at',
        'deleted_at'
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'status' => ApplicationStatus::class
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

    public function other_mobility(): HasOne
    {
        return $this->hasOne(OtherMobility::class);
    }

    public function application_progress(): HasOne
    {
        return $this->hasOne(ApplicationProgress::class);
    }

    public function personal_details(): HasOne
    {
        return $this->hasOne(PersonalDetails::class);
    }

    public function home_institution_form(): HasOne
    {
        return $this->hasOne(HomeInstitutionForm::class);
    }

    public function proposed_host_universities(): HasOne
    {
        return $this->hasOne(ProposedHostUniversities::class);
    }

    public function motivation_and_added_value(): HasOne
    {
        return $this->hasOne(MotivationAndAddedValue::class);
    }

    public function documents_upload(): HasMany
    {
        return $this->hasMany(UploadedDocument::class);
    }
}
