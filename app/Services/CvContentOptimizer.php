<?php

namespace App\Services;

use Illuminate\Support\Collection;

class CvContentOptimizer
{
    private const int LINES_PER_PAGE = 56;

    private const int MAX_PAGES = 3;

    private const int TARGET_PAGES = 1;

    private const int CHARS_PER_LINE = 92;

    /**
     * @param  object  $profile
     * @param  Collection<int, object>  $experiences
     * @param  Collection<int, object>  $education
     * @param  Collection<int, object>  $skills
     * @param  Collection<int, object>  $projects
     * @return array{profile: object, experiences: Collection, education: Collection, skills: Collection, projects: Collection}
     */
    public function optimize(
        object $profile,
        Collection $experiences,
        Collection $education,
        Collection $skills,
        Collection $projects,
    ): array {
        $profile = clone $profile;
        $experiences = $experiences->map(fn ($item) => clone $item);
        $education = $education->map(fn ($item) => clone $item);
        $skills = $skills->map(fn ($item) => clone $item);
        $projects = $projects->map(fn ($item) => clone $item);

        $profile->summary = $this->truncateText($profile->summary, 420);

        $maxLines = self::LINES_PER_PAGE * self::MAX_PAGES;
        $targetLines = self::LINES_PER_PAGE * self::TARGET_PAGES;

        foreach ([520, 380, 280, 200, 140] as $descriptionLimit) {
            $this->applyDescriptionLimit($experiences, $projects, $descriptionLimit);

            if ($this->estimateLines($profile, $experiences, $education, $skills, $projects) <= $maxLines) {
                break;
            }
        }

        foreach ([8, 6, 5, 4] as $experienceLimit) {
            if ($experiences->count() > $experienceLimit) {
                $experiences = $experiences->take($experienceLimit)->values();
            }

            if ($this->estimateLines($profile, $experiences, $education, $skills, $projects) <= $maxLines) {
                break;
            }
        }

        foreach ([3, 2, 1, 0] as $projectLimit) {
            if ($projects->count() > $projectLimit) {
                $projects = $projects->take($projectLimit)->values();
            }

            if ($this->estimateLines($profile, $experiences, $education, $skills, $projects) <= $maxLines) {
                break;
            }
        }

        if ($education->count() > 2) {
            $education = $education->take(2)->values();
        }

        if ($this->estimateLines($profile, $experiences, $education, $skills, $projects) > $maxLines) {
            $profile->summary = $this->truncateText($profile->summary, 260);
        }

        if ($this->estimateLines($profile, $experiences, $education, $skills, $projects) > $targetLines) {
            $this->applyDescriptionLimit($experiences, $projects, 180);
            $profile->summary = $this->truncateText($profile->summary, 320);
        }

        return [
            'profile' => $profile,
            'experiences' => $experiences,
            'education' => $education,
            'skills' => $skills,
            'projects' => $projects,
        ];
    }

    /**
     * @param  Collection<int, object>  $experiences
     * @param  Collection<int, object>  $projects
     */
    private function applyDescriptionLimit(Collection $experiences, Collection $projects, int $limit): void
    {
        $experiences->each(function ($experience) use ($limit) {
            $experience->description = $this->truncateText($experience->description ?? null, $limit);
        });

        $projects->each(function ($project) use ($limit) {
            $project->description = $this->truncateText($project->description ?? null, min($limit, 220));
        });
    }

    /**
     * @param  Collection<int, object>  $experiences
     * @param  Collection<int, object>  $education
     * @param  Collection<int, object>  $skills
     * @param  Collection<int, object>  $projects
     */
    private function estimateLines(
        object $profile,
        Collection $experiences,
        Collection $education,
        Collection $skills,
        Collection $projects,
    ): int {
        $lines = 5;

        if ($profile->summary ?? null) {
            $lines += 2 + $this->textLines($profile->summary);
        }

        if ($experiences->isNotEmpty()) {
            $lines += 2;
        }

        foreach ($experiences as $experience) {
            $lines += 2 + $this->textLines($experience->description ?? null);
        }

        if ($education->isNotEmpty()) {
            $lines += 2 + ($education->count() * 2);
        }

        if ($skills->isNotEmpty()) {
            $lines += 2 + $skills->groupBy('category')->count();
        }

        if ($projects->isNotEmpty()) {
            $lines += 2;

            foreach ($projects as $project) {
                $lines += 1 + $this->textLines($project->description ?? null);

                if (! empty($project->technologies_used)) {
                    $lines += 1;
                }
            }
        }

        return $lines;
    }

    private function textLines(?string $text): int
    {
        if (! $text) {
            return 0;
        }

        $normalized = trim(preg_replace('/\s+/', ' ', $text) ?? '');

        if ($normalized === '') {
            return 0;
        }

        return max(1, (int) ceil(mb_strlen($normalized) / self::CHARS_PER_LINE));
    }

    private function truncateText(?string $text, int $maxChars): ?string
    {
        if (! $text) {
            return null;
        }

        $normalized = trim(preg_replace('/\s+/', ' ', $text) ?? '');

        if ($normalized === '') {
            return null;
        }

        if (mb_strlen($normalized) <= $maxChars) {
            return $normalized;
        }

        $truncated = mb_substr($normalized, 0, $maxChars - 1);
        $lastSpace = mb_strrpos($truncated, ' ');

        if ($lastSpace !== false && $lastSpace > (int) ($maxChars * 0.6)) {
            $truncated = mb_substr($truncated, 0, $lastSpace);
        }

        return rtrim($truncated, '.,;:-').'…';
    }
}
