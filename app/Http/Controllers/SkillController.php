<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class SkillController extends Controller
{
    public function index(): Response
    {
        $skills = Skill::where('user_id', auth()->id())
            ->orderBy('category')
            ->orderBy('name')
            ->get();

        return Inertia::render('Skills', [
            'skills' => $skills,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|in:Technical,Soft,Language,Design,Tool',
            'proficiency_level' => 'required|string|in:beginner,intermediate,advanced,expert',
        ]);

        $validated['user_id'] = auth()->id();

        Skill::create($validated);

        return redirect()->back()->with('success', 'Skill added.');
    }

    public function update(Request $request, Skill $skill): RedirectResponse
    {
        $this->authorize('update', $skill);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|in:Technical,Soft,Language,Design,Tool',
            'proficiency_level' => 'required|string|in:beginner,intermediate,advanced,expert',
        ]);

        $skill->update($validated);

        return redirect()->back()->with('success', 'Skill updated.');
    }

    public function destroy(Skill $skill): RedirectResponse
    {
        $this->authorize('delete', $skill);

        $skill->delete();

        return redirect()->back()->with('success', 'Skill deleted.');
    }
}
