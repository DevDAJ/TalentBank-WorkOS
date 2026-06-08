<?php

namespace App\Http\Controllers;

use App\Models\WorkExperience;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class WorkExperienceController extends Controller
{
    public function index(): Response
    {
        $experiences = WorkExperience::where('user_id', auth()->id())
            ->orderBy('start_date', 'desc')
            ->get();

        return Inertia::render('Experience', [
            'experiences' => $experiences,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'company' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'is_current' => 'boolean',
            'description' => 'nullable|string',
        ]);

        $validated['user_id'] = auth()->id();

        WorkExperience::create($validated);

        return redirect()->back()->with('success', 'Work experience added.');
    }

    public function update(Request $request, WorkExperience $workExperience): RedirectResponse
    {
        $this->authorize('update', $workExperience);

        $validated = $request->validate([
            'company' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'is_current' => 'boolean',
            'description' => 'nullable|string',
        ]);

        $workExperience->update($validated);

        return redirect()->back()->with('success', 'Work experience updated.');
    }

    public function destroy(WorkExperience $workExperience): RedirectResponse
    {
        $this->authorize('delete', $workExperience);

        $workExperience->delete();

        return redirect()->back()->with('success', 'Work experience deleted.');
    }
}
