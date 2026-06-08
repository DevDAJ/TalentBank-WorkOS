<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ProjectController extends Controller
{
    public function index(): Response
    {
        $projects = Project::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return Inertia::render('Projects', [
            'projects' => $projects,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'technologies_used' => 'nullable|array',
            'technologies_used.*' => 'string',
            'url' => 'nullable|url|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after:start_date',
        ]);

        $validated['user_id'] = auth()->id();

        Project::create($validated);

        return redirect()->back()->with('success', 'Project added.');
    }

    public function update(Request $request, Project $project): RedirectResponse
    {
        $this->authorize('update', $project);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'technologies_used' => 'nullable|array',
            'technologies_used.*' => 'string',
            'url' => 'nullable|url|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after:start_date',
        ]);

        $project->update($validated);

        return redirect()->back()->with('success', 'Project updated.');
    }

    public function destroy(Project $project): RedirectResponse
    {
        $this->authorize('delete', $project);

        $project->delete();

        return redirect()->back()->with('success', 'Project deleted.');
    }
}
