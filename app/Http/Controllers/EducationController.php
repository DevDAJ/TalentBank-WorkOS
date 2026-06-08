<?php

namespace App\Http\Controllers;

use App\Models\Education;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class EducationController extends Controller
{
    public function index(): Response
    {
        $education = Education::where('user_id', auth()->id())
            ->orderBy('start_date', 'desc')
            ->get();

        return Inertia::render('Education', [
            'education' => $education,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'institution' => 'required|string|max:255',
            'degree' => 'required|string|max:255',
            'field_of_study' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'gpa' => 'nullable|numeric|min:0|max:4',
        ]);

        $validated['user_id'] = auth()->id();

        Education::create($validated);

        return redirect()->back()->with('success', 'Education added.');
    }

    public function update(Request $request, Education $education): RedirectResponse
    {
        $this->authorize('update', $education);

        $validated = $request->validate([
            'institution' => 'required|string|max:255',
            'degree' => 'required|string|max:255',
            'field_of_study' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'gpa' => 'nullable|numeric|min:0|max:4',
        ]);

        $education->update($validated);

        return redirect()->back()->with('success', 'Education updated.');
    }

    public function destroy(Education $education): RedirectResponse
    {
        $this->authorize('delete', $education);

        $education->delete();

        return redirect()->back()->with('success', 'Education deleted.');
    }
}
