<?php

use App\Http\Controllers\CareerSuggestionController;
use App\Http\Controllers\CertificationController;
use App\Http\Controllers\CVController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SalaryController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\TailoredResumeController;
use App\Http\Controllers\WorkExperienceController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    $user = auth()->user();
    return Inertia::render('Dashboard', [
        'skills' => $user->skills,
        'experiences' => $user->workExperiences,
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'manage'])->name('profile.edit');
    Route::patch('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [\App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/experience', [WorkExperienceController::class, 'store'])->name('experience.store');
    Route::put('/experience/{workExperience}', [WorkExperienceController::class, 'update'])->name('experience.update');
    Route::delete('/experience/{workExperience}', [WorkExperienceController::class, 'destroy'])->name('experience.destroy');

    Route::post('/education', [EducationController::class, 'store'])->name('education.store');
    Route::put('/education/{education}', [EducationController::class, 'update'])->name('education.update');
    Route::delete('/education/{education}', [EducationController::class, 'destroy'])->name('education.destroy');

    Route::post('/skills', [SkillController::class, 'store'])->name('skills.store');
    Route::put('/skills/{skill}', [SkillController::class, 'update'])->name('skills.update');
    Route::delete('/skills/{skill}', [SkillController::class, 'destroy'])->name('skills.destroy');

    Route::post('/certifications', [CertificationController::class, 'store'])->name('certifications.store');
    Route::put('/certifications/{certification}', [CertificationController::class, 'update'])->name('certifications.update');
    Route::delete('/certifications/{certification}', [CertificationController::class, 'destroy'])->name('certifications.destroy');

    Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
    Route::put('/projects/{project}', [ProjectController::class, 'update'])->name('projects.update');
    Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');

    Route::get('/cv', [CVController::class, 'index'])->name('cv.index');
    Route::get('/cv/preview', [CVController::class, 'preview'])->name('cv.preview');

    Route::get('/career', [CareerSuggestionController::class, 'index'])->name('career.index');

    Route::get('/tailored', [TailoredResumeController::class, 'index'])->name('tailored.index');
    Route::post('/tailored/generate', [TailoredResumeController::class, 'generate'])->name('tailored.generate');
    Route::get('/tailored/download', [TailoredResumeController::class, 'downloadPdf'])->name('tailored.download');

    Route::post('/salary/check', [SalaryController::class, 'check'])->name('salary.check');
    Route::get('/salary/current-role', [SalaryController::class, 'currentRole'])->name('salary.current-role');
});

require __DIR__.'/auth.php';
