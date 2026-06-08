<?php

namespace App\Http\Controllers;

use App\Models\Certification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CertificationController extends Controller
{
    public function index(): Response
    {
        $certifications = Certification::where('user_id', auth()->id())
            ->orderBy('issue_date', 'desc')
            ->get();

        return Inertia::render('Certifications', [
            'certifications' => $certifications,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'issuing_organization' => 'required|string|max:255',
            'issue_date' => 'required|date',
            'expiration_date' => 'nullable|date|after:issue_date',
            'credential_url' => 'nullable|url|max:255',
        ]);

        $validated['user_id'] = auth()->id();

        Certification::create($validated);

        return redirect()->back()->with('success', 'Certification added.');
    }

    public function update(Request $request, Certification $certification): RedirectResponse
    {
        $this->authorize('update', $certification);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'issuing_organization' => 'required|string|max:255',
            'issue_date' => 'required|date',
            'expiration_date' => 'nullable|date|after:issue_date',
            'credential_url' => 'nullable|url|max:255',
        ]);

        $certification->update($validated);

        return redirect()->back()->with('success', 'Certification updated.');
    }

    public function destroy(Certification $certification): RedirectResponse
    {
        $this->authorize('delete', $certification);

        $certification->delete();

        return redirect()->back()->with('success', 'Certification deleted.');
    }
}
