<?php

namespace App\Http\Controllers\Api;

use App\Models\Application;
use App\Models\ApplicationEvaluation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApplicationEvaluationController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'application_id' => 'required|exists:applications,id',
            'averageGrade' => 'nullable|numeric',
            'additionalEngagement' => 'nullable|numeric',
            'yearLevelStudy' => 'nullable|integer',
            'totalAchievement' => 'nullable|numeric',
            'applicationQuality' => 'nullable|numeric',
            'previousErasmusParticipation' => 'nullable|numeric',
            'programLanguageSkills' => 'nullable|numeric',
            'totalOther' => 'nullable|numeric',
            'overallResult' => 'nullable|numeric',
        ]);

        $evaluation = ApplicationEvaluation::create($request->all());

        $application = Application::find($request->application_id);
        if ($application) {
            $application->score = $request->overallResult;
            $application->save();
        }

        return response()->json($evaluation, 201);
    }

    
    public function update(Request $request, $applicationId) {
        
        $evaluation = ApplicationEvaluation::where('application_id', $applicationId)->first();
    
        if ($evaluation) {
            $evaluation->update($request->all());

            $application = Application::find($applicationId);
            if ($application) {
                $application->score = $request->overallResult;
                $application->save();
            }

            return response()->json($evaluation, 200);
        } else {
            return response()->json(['error' => 'Evaluacija nije pronađena'], 404);
        }
    }

    public function show($applicationId) {
        $evaluation = ApplicationEvaluation::where('application_id', $applicationId)->first();
    
        if ($evaluation) {
            return response()->json($evaluation, 200);
        } else {
            $emptyEvaluation = [
                'application_id' => null,
                'averageGrade' => null,
                'additionalEngagement' => null,
                'yearLevelStudy' => null,
                'totalAchievement' => null,
                'applicationQuality' => null,
                'previousErasmusParticipation' => null,
                'programLanguageSkills' => null,
                'totalOther' => null,
                'overallResult' => null
            ];
    
            return response()->json($emptyEvaluation, 200);
        }
    }
}
