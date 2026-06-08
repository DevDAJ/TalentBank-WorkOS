<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\GeneratesCvPdf;
use App\Models\Education;
use App\Models\Project;
use App\Models\Skill;
use App\Models\WorkExperience;
use App\Services\JobDescriptionKeywordExtractor;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TailoredResumeController extends Controller
{
    use GeneratesCvPdf;
    public function index(): Response
    {
        return Inertia::render('TailoredResume', [
            'generated' => null,
        ]);
    }

    public function generate(Request $request)
    {
        $validated = $request->validate([
            'job_title' => 'required|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'job_description' => 'required|string',
            'expected_salary' => 'nullable|numeric|min:0',
        ]);

        $user = auth()->user();

        $skills = Skill::where('user_id', $user->id)->get();
        $userSkillNames = $skills->pluck('name')->toArray();

        $extractor = new JobDescriptionKeywordExtractor();
        $jdKeywords = $extractor->extract($validated['job_description'], $userSkillNames);
        [$matchedKeywords, $missingKeywords] = $extractor->matchAgainstSkills($jdKeywords, $userSkillNames);

        $experiences = WorkExperience::where('user_id', $user->id)->orderBy('start_date', 'desc')->get();
        $education = Education::where('user_id', $user->id)->orderBy('start_date', 'desc')->get();
        $projects = Project::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
        $matchScore = count($jdKeywords) > 0
            ? round((count($matchedKeywords) / count($jdKeywords)) * 100)
            : 0;

        $rankedExperiences = $experiences->map(function ($exp) use ($jdKeywords) {
            $exp->relevance = $this->calculateRelevance($exp->description . ' ' . $exp->position, $jdKeywords);
            return $exp;
        })->sortByDesc('relevance')->values();

        $salaryAnalysis = null;
        if ($request->filled('expected_salary')) {
            $benchmark = \App\Models\SalaryBenchmark::where('role_title', $validated['job_title'])
                ->where('seniority_level', $this->inferSeniority($user, $experiences))
                ->where('location', $user->location ?? 'Remote US')
                ->first();

            if ($benchmark) {
                $input = $validated['expected_salary'];
                if ($input < $benchmark->p25) {
                    $verdict = 'below_market';
                } elseif ($input > $benchmark->p75) {
                    $verdict = 'above_market';
                } else {
                    $verdict = 'on_target';
                }

                $salaryAnalysis = [
                    'input_salary' => $input,
                    'p25' => $benchmark->p25,
                    'p50' => $benchmark->p50,
                    'p75' => $benchmark->p75,
                    'verdict' => $verdict,
                ];
            }
        }

        $generated = [
            'job_title' => $validated['job_title'],
            'company_name' => $validated['company_name'] ?? '',
            'summary' => $this->generateSummary($user, $validated['job_title'], $jdKeywords),
            'experiences' => $rankedExperiences,
            'skills' => $skills,
            'education' => $education,
            'projects' => $projects,
            'match_score' => $matchScore,
            'matched_keywords' => array_values($matchedKeywords),
            'missing_keywords' => array_values($missingKeywords),
            'salary_analysis' => $salaryAnalysis,
        ];

        session(['tailored_resume_pdf' => [
            'job_title' => $generated['job_title'],
            'company_name' => $generated['company_name'],
            'summary' => $generated['summary'],
            'experiences' => $generated['experiences'],
            'skills' => $generated['skills'],
            'education' => $generated['education'],
            'projects' => $generated['projects'],
        ]]);

        return Inertia::render('TailoredResume', [
            'generated' => $generated,
        ]);
    }

    public function downloadPdf(Request $request)
    {
        $data = session('tailored_resume_pdf');

        if (!$data) {
            abort(404, 'No tailored resume found. Please generate a resume first.');
        }

        $template = $request->input('template', 'modern');
        if (!in_array($template, ['classic', 'modern', 'minimal'], true)) {
            $template = 'modern';
        }

        $user = auth()->user();
        $originalSummary = $user->summary;
        $user->summary = $data['summary'];

        $pdf = $this->makeCvPdf(
            $template,
            $user,
            collect($data['experiences'] ?? []),
            collect($data['education'] ?? []),
            collect($data['skills'] ?? []),
            collect($data['projects'] ?? []),
        );

        $user->summary = $originalSummary;

        return $pdf->download("tailored-resume-{$template}.pdf");
    }

    private function calculateRelevance(?string $text, array $keywords): int
    {
        if (!$text) return 0;
        $lower = strtolower($text);
        $score = 0;
        foreach ($keywords as $kw) {
            $score += substr_count($lower, $kw);
        }
        return $score;
    }

    private function generateSummary($user, string $jobTitle, array $keywords): string
    {
        $skillList = $user->skills->pluck('name')->take(5)->implode(', ');
        $totalYears = $user->workExperiences->reduce(function ($carry, $exp) {
            $start = $exp->start_date;
            $end = $exp->end_date ?? now();
            return $carry + $start->diffInYears($end);
        }, 0);

        return sprintf(
            '%s with %d+ years of experience specializing in %s. Proven track record in %s. '
            . 'Seeking to leverage expertise as a %s to drive impactful results.',
            $user->title ?? 'Professional',
            max(1, $totalYears),
            $skillList,
            implode(', ', array_slice($keywords, 0, 4)),
            $jobTitle
        );
    }

    private function inferSeniority($user, $experiences): string
    {
        $totalYears = $experiences->reduce(function ($carry, $exp) {
            $end = $exp->end_date ?? now();
            return $carry + $exp->start_date->diffInYears($end);
        }, 0);

        if ($totalYears < 2) return 'junior';
        if ($totalYears < 5) return 'mid';
        if ($totalYears < 10) return 'senior';
        return 'lead';
    }
}
