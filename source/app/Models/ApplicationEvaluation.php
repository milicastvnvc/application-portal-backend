<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationEvaluation extends Model
{
    use HasFactory;

    protected $table = 'application_evaluation';

    protected $fillable = [
        'application_id',
        'averageGrade',
        'additionalEngagement',
        'yearLevelStudy',
        'totalAchievement',
        'applicationQuality',
        'previousErasmusParticipation',
        'programLanguageSkills',
        'totalOther',
        'overallResult'
    ];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }
}
