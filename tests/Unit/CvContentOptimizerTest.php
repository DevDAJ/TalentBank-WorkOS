<?php

use App\Services\CvContentOptimizer;
use Illuminate\Support\Collection;

test('cv content optimizer trims oversized resumes toward three pages', function () {
    $profile = (object) [
        'summary' => str_repeat('Experienced engineer with strong delivery skills. ', 20),
    ];

    $experiences = Collection::make(range(1, 10))->map(fn (int $index) => (object) [
        'description' => str_repeat("Achievement {$index}. ", 40),
    ]);

    $education = Collection::make(range(1, 4))->map(fn () => (object) []);
    $skills = Collection::make(range(1, 12))->map(fn (int $index) => (object) ['category' => "Category {$index}"]);
    $projects = Collection::make(range(1, 6))->map(fn (int $index) => (object) [
        'description' => str_repeat("Project {$index}. ", 20),
        'technologies_used' => ['PHP', 'Laravel'],
    ]);

    $optimized = app(CvContentOptimizer::class)->optimize(
        $profile,
        $experiences,
        $education,
        $skills,
        $projects,
    );

    expect($optimized['experiences'])->toHaveCount(8)
        ->and($optimized['projects'])->toHaveCount(3)
        ->and($optimized['education'])->toHaveCount(2)
        ->and(mb_strlen((string) $optimized['profile']->summary))->toBeLessThan(500)
        ->and(mb_strlen((string) $optimized['experiences']->first()->description))->toBeLessThanOrEqual(520);
});

test('cv content optimizer leaves compact resumes mostly intact', function () {
    $profile = (object) ['summary' => 'Product engineer focused on backend systems.'];
    $experiences = Collection::make([
        (object) ['description' => 'Built APIs and improved deployment workflows.'],
        (object) ['description' => 'Led a migration to PostgreSQL.'],
    ]);
    $education = Collection::make([(object) []]);
    $skills = Collection::make([(object) ['category' => 'Backend']]);
    $projects = Collection::make([(object) ['description' => 'Internal tooling platform.', 'technologies_used' => ['PHP']]]);

    $optimized = app(CvContentOptimizer::class)->optimize(
        $profile,
        $experiences,
        $education,
        $skills,
        $projects,
    );

    expect($optimized['experiences'])->toHaveCount(2)
        ->and($optimized['projects'])->toHaveCount(1)
        ->and($optimized['profile']->summary)->toBe('Product engineer focused on backend systems.');
});
