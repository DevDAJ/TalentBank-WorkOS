<?php

namespace App\Http\Controllers;

use App\Models\SalaryBenchmark;
use App\Models\WorkExperience;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SalaryController extends Controller
{
    public function check(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'role_title' => 'required|string|max:255',
            'seniority_level' => 'required|string|in:junior,mid,senior,lead',
            'location' => 'required|string|max:255',
            'salary' => 'required|numeric|min:0',
        ]);

        $benchmark = SalaryBenchmark::where('role_title', $validated['role_title'])
            ->where('seniority_level', $validated['seniority_level'])
            ->where('location', $validated['location'])
            ->first();

        if (!$benchmark) {
            return response()->json([
                'found' => false,
                'message' => 'No benchmark data found for this combination.',
            ]);
        }

        $input = $validated['salary'];
        if ($input < $benchmark->p25) {
            $verdict = 'below_market';
            $label = 'Below Market';
        } elseif ($input > $benchmark->p75) {
            $verdict = 'above_market';
            $label = 'Above Market';
        } else {
            $verdict = 'on_target';
            $label = 'On Target';
        }

        return response()->json([
            'found' => true,
            'benchmark' => $benchmark,
            'input_salary' => $input,
            'percentile' => $this->calculatePercentile($input, $benchmark),
            'verdict' => $verdict,
            'label' => $label,
        ]);
    }

    public function currentRole(Request $request): JsonResponse
    {
        $user = auth()->user();
        $latestExp = WorkExperience::where('user_id', $user->id)
            ->where('is_current', true)
            ->orWhere(function ($q) use ($user) {
                $q->where('user_id', $user->id)->whereNull('end_date');
            })
            ->first();

        if (!$latestExp) {
            $latestExp = WorkExperience::where('user_id', $user->id)
                ->orderBy('start_date', 'desc')
                ->first();
        }

        if (!$latestExp) {
            return response()->json(['found' => false]);
        }

        return response()->json([
            'found' => true,
            'role_title' => $latestExp->position,
            'company' => $latestExp->company,
        ]);
    }

    private function calculatePercentile(int $salary, $benchmark): float
    {
        if ($salary <= $benchmark->p25) {
            return 25 * ($salary / $benchmark->p25);
        }
        if ($salary <= $benchmark->p50) {
            return 25 + 25 * (($salary - $benchmark->p25) / ($benchmark->p50 - $benchmark->p25));
        }
        if ($salary <= $benchmark->p75) {
            return 50 + 25 * (($salary - $benchmark->p50) / ($benchmark->p75 - $benchmark->p50));
        }
        return 75 + 25 * min(1, ($salary - $benchmark->p75) / $benchmark->p75);
    }
}
