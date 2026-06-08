<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        @include('cv.partials.pdf-layout')
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 10pt; line-height: 1.35; color: #1a1a1a; }
        h1 { font-size: 18pt; margin: 0 0 2pt 0; color: #2563eb; }
        .contact { font-size: 9pt; margin-bottom: 8pt; color: #555; }
        .contact span { margin: 0 8pt 0 0; }
        h2 { font-size: 11pt; color: #2563eb; border-bottom: 1.5px solid #2563eb; padding-bottom: 1pt; margin: 8pt 0 4pt 0; }
        .entry-header { display: flex; justify-content: space-between; }
        .entry-title { font-weight: bold; font-size: 10.5pt; color: #1a1a1a; }
        .entry-subtitle { font-size: 9.5pt; color: #444; }
        .entry-date { font-size: 9pt; color: #777; text-align: right; white-space: nowrap; }
        .entry-desc { font-size: 9pt; margin: 2pt 0 0 0; white-space: pre-line; color: #333; }
        ul { margin: 1pt 0 0 12pt; padding: 0; }
        li { font-size: 9pt; margin-bottom: 0; }
        .skill-group { margin-bottom: 2pt; font-size: 9pt; }
        .skill-group strong { color: #2563eb; }
    </style>
</head>
<body>
    <h1>{{ $profile->name }}</h1>
    <div class="contact">
        @if($profile->phone){{ $profile->phone }} &bull; @endif
        {{ $profile->email }}
        @if($profile->location) &bull; {{ $profile->location }} @endif
        @if($profile->linkedin_url) &bull; {{ $profile->linkedin_url }} @endif
        @if($profile->github_url) &bull; {{ $profile->github_url }} @endif
        @if($profile->website) &bull; {{ $profile->website }} @endif
    </div>

    @if($profile->summary)
    <div class="section">
        <h2>Professional Summary</h2>
        <p style="font-size:9pt;">{{ $profile->summary }}</p>
    </div>
    @endif

    @if($experiences->count())
    <div class="section">
        <h2>Experience</h2>
        @foreach($experiences as $exp)
        <div class="entry">
            <div class="entry-header">
                <div>
                    <div class="entry-title">{{ $exp->position }}</div>
                    <div class="entry-subtitle">{{ $exp->company }}@if($exp->location), {{ $exp->location }}@endif</div>
                </div>
                <div class="entry-date">{{ $exp->start_date->format('M Y') }} – {{ $exp->is_current ? 'Present' : $exp->end_date->format('M Y') }}</div>
            </div>
            @if($exp->description)
            <div class="entry-desc">{{ $exp->description }}</div>
            @endif
        </div>
        @endforeach
    </div>
    @endif

    @if($education->count())
    <div class="section">
        <h2>Education</h2>
        @foreach($education as $edu)
        <div class="entry">
            <div class="entry-header">
                <div>
                    <div class="entry-title">{{ $edu->degree }} in {{ $edu->field_of_study }}</div>
                    <div class="entry-subtitle">{{ $edu->institution }}@if($edu->gpa) &mdash; GPA: {{ $edu->gpa }} @endif</div>
                </div>
                <div class="entry-date">{{ $edu->start_date->format('Y') }} – {{ $edu->end_date?->format('Y') ?? 'Present' }}</div>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    @if($skills->count())
    <div class="section">
        <h2>Skills</h2>
        @foreach($skills->groupBy('category') as $category => $catSkills)
        <div class="skill-group">
            <strong>{{ $category }}:</strong> {{ $catSkills->pluck('name')->join(', ') }}
        </div>
        @endforeach
    </div>
    @endif

    @if(isset($projects) && $projects->count())
    <div class="section">
        <h2>Projects</h2>
        @foreach($projects as $proj)
        <div class="entry">
            <div class="entry-title">{{ $proj->name }}</div>
            @if($proj->description)<p style="font-size:9pt; margin:1pt 0;">{{ $proj->description }}</p>@endif
            @if($proj->technologies_used)<p style="font-size:8.5pt; color:#555; margin:1pt 0;">{{ implode(', ', $proj->technologies_used) }}</p>@endif
        </div>
        @endforeach
    </div>
    @endif
</body>
</html>
