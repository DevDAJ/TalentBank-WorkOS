<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        @include('cv.partials.pdf-layout')
        body { font-family: 'Times New Roman', Georgia, serif; font-size: 10pt; line-height: 1.3; color: #000; }
        h1 { font-size: 17pt; margin: 0 0 3pt 0; text-transform: uppercase; letter-spacing: 0.8pt; }
        .contact { font-size: 9.5pt; margin-bottom: 8pt; color: #333; }
        .contact span { margin: 0 8pt 0 0; }
        h2 { font-size: 11.5pt; text-transform: uppercase; border-bottom: 1px solid #000; padding-bottom: 1pt; margin: 8pt 0 4pt 0; letter-spacing: 0.4pt; }
        .entry-header { display: flex; justify-content: space-between; }
        .entry-title { font-weight: bold; font-size: 10.5pt; }
        .entry-subtitle { font-style: italic; font-size: 9.5pt; color: #333; }
        .entry-date { font-size: 9.5pt; color: #555; text-align: right; }
        .entry-desc { font-size: 9.5pt; margin: 1pt 0 0 0; white-space: pre-line; }
        ul { margin: 1pt 0 0 12pt; padding: 0; }
        li { font-size: 9.5pt; margin-bottom: 0; }
        .skill-item { font-size: 9.5pt; }
    </style>
</head>
<body>
    <h1>{{ $profile->name }}</h1>
    <div class="contact">
        @if($profile->phone)<span>{{ $profile->phone }}</span>@endif
        @if($profile->email)<span>{{ $profile->email }}</span>@endif
        @if($profile->location)<span>{{ $profile->location }}</span>@endif
        @if($profile->website)<span>{{ $profile->website }}</span>@endif
        @if($profile->linkedin_url)<span>{{ $profile->linkedin_url }}</span>@endif
        @if($profile->github_url)<span>{{ $profile->github_url }}</span>@endif
    </div>

    @if($profile->summary)
    <div class="section">
        <h2>Professional Summary</h2>
        <p style="font-size:9.5pt;">{{ $profile->summary }}</p>
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
                <div class="entry-date">
                    {{ $exp->start_date->format('M Y') }} – {{ $exp->is_current ? 'Present' : $exp->end_date->format('M Y') }}
                </div>
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
                    <div class="entry-subtitle">{{ $edu->institution }}</div>
                </div>
                <div class="entry-date">
                    {{ $edu->start_date->format('Y') }} – {{ $edu->end_date?->format('Y') ?? 'Present' }}
                    @if($edu->gpa) | GPA: {{ $edu->gpa }} @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    @if($skills->count())
    <div class="section">
        <h2>Skills</h2>
        @foreach($skills->groupBy('category') as $category => $catSkills)
        <p style="font-size:9.5pt; margin:1pt 0;">
            <strong>{{ $category }}:</strong>
            {{ $catSkills->pluck('name')->join(', ') }}
        </p>
        @endforeach
    </div>
    @endif

    @if(isset($projects) && $projects->count())
    <div class="section">
        <h2>Projects</h2>
        @foreach($projects as $proj)
        <div class="entry">
            <div class="entry-title">{{ $proj->name }}</div>
            @if($proj->description)<p style="font-size:10pt; margin:1pt 0;">{{ $proj->description }}</p>@endif
            @if($proj->technologies_used)<p style="font-size:9pt; color:#444; margin:1pt 0;"><em>{{ implode(', ', $proj->technologies_used) }}</em></p>@endif
        </div>
        @endforeach
    </div>
    @endif
</body>
</html>
