<?php

namespace App\Http\Controllers;

use App\Models\CareerSuggestion;
use Inertia\Inertia;
use Inertia\Response;

class CareerSuggestionController extends Controller
{
    public function index(): Response
    {
        $suggestions = CareerSuggestion::where('user_id', auth()->id())
            ->orderBy('match_score', 'desc')
            ->get();

        return Inertia::render('CareerSuggestions', [
            'suggestions' => $suggestions,
        ]);
    }
}
