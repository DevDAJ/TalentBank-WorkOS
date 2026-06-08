<?php

namespace App\Http\Controllers;

use App\Models\Education;
use App\Models\Project;
use App\Models\Skill;
use App\Models\WorkExperience;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CVController extends Controller
{
    public function index(): Response
    {
        $user = auth()->user();

        return Inertia::render('CVBuilder', [
            'profile' => $user,
            'experiences' => WorkExperience::where('user_id', $user->id)->orderBy('start_date', 'desc')->get(),
            'education' => Education::where('user_id', $user->id)->orderBy('start_date', 'desc')->get(),
            'skills' => Skill::where('user_id', $user->id)->orderBy('category')->get(),
            'projects' => Project::where('user_id', $user->id)->orderBy('created_at', 'desc')->get(),
        ]);
    }

    public function preview(Request $request)
    {
        $user = auth()->user();
        $template = $request->input('template', 'modern');

        $data = [
            'profile' => $user,
            'experiences' => WorkExperience::where('user_id', $user->id)->orderBy('start_date', 'desc')->get(),
            'education' => Education::where('user_id', $user->id)->orderBy('start_date', 'desc')->get(),
            'skills' => Skill::where('user_id', $user->id)->orderBy('category')->get(),
            'projects' => Project::where('user_id', $user->id)->orderBy('created_at', 'desc')->get(),
            'template' => $template,
        ];

        $pdf = Pdf::loadView("cv.templates.{$template}", $data);

        return $pdf->download('cv.pdf');
    }
}
