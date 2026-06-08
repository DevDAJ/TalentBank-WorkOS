<?php

namespace App\Http\Controllers\Concerns;

use App\Services\CvContentOptimizer;
use Barryvdh\DomPDF\Facade\Pdf;
use Barryvdh\DomPDF\PDF as DomPdfDocument;
use Illuminate\Support\Collection;

trait GeneratesCvPdf
{
    /**
     * @param  Collection<int, object>  $experiences
     * @param  Collection<int, object>  $education
     * @param  Collection<int, object>  $skills
     * @param  Collection<int, object>  $projects
     */
    protected function makeCvPdf(
        string $template,
        object $profile,
        Collection $experiences,
        Collection $education,
        Collection $skills,
        Collection $projects,
    ): DomPdfDocument {
        $optimized = app(CvContentOptimizer::class)->optimize(
            $profile,
            $experiences,
            $education,
            $skills,
            $projects,
        );

        return Pdf::loadView("cv.templates.{$template}", $optimized)
            ->setPaper('a4', 'portrait');
    }
}
