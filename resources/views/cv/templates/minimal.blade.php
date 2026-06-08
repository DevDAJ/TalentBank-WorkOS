<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        @include('cv.partials.pdf-layout')
        body { font-family: 'Calibri', 'Corbel', sans-serif; font-size: 9.5pt; line-height: 1.4; color: #222; }
        h1 { font-size: 19pt; margin: 0 0 2pt 0; font-weight: 300; letter-spacing: 1.5pt; text-transform: uppercase; }
        .contact { font-size: 8.5pt; margin-bottom: 8pt; color: #666; }
        .contact span { margin: 0 8pt 0 0; }
        h2 { font-size: 10pt; text-transform: uppercase; letter-spacing: 1.2pt; margin: 8pt 0 4pt 0; font-weight: 600; color: #333; }
        hr { border: none; border-top: 0.5px solid #bbb; margin: 0 0 4pt 0; }
        .entry-header { display: flex; justify-content: space-between; }
        .entry-title { font-weight: 600; font-size: 10pt; }
        .entry-subtitle { font-size: 9pt; color: #555; }
        .entry-date { font-size: 8.5pt; color: #666; text-align: right; white-space: nowrap; }
        .entry-desc { font-size: 9pt; margin: 2pt 0 0 0; white-space: pre-line; color: #333; }
        ul { margin: 1pt 0 0 12pt; padding: 0; }
        li { font-size: 8.5pt; margin-bottom: 0; }
        .skill-group { margin-bottom: 1pt; font-size: 9pt; }
        .skill-group strong { font-weight: 600; }
        .summary { font-size: 9pt; color: #333; }
    </style>
</head>
<body>
    <h1>{{ $profile->name }}</h1>
    <div class="contact">
        @if($profile->phone)<span>{{ $profile->phone }}</span>@endif
        @if($profile->email)<span>{{ $profile->email }}</span>@endif
        @if($profile->location)<span>{{ $profile->location }}</span>@endif
        @if($profile->linkedin_url)<span>{{ $profile->linkedin_url }}</span>@endif
        @if($profile->github_url)<span>{{ $profile->github_url }}</span>@endif
        @if($profile->website)<span>{{ $profile->website }}</span>@endif
    </div>

    @if($profile->summary)
    <div class="section">
        <h2>About</h2>
        <hr>
        <p class="summary">{{ $profile->summary }}</p>
    </div>
    @endif

    @if($experiences->count())
    <div class="section">
        <h2>Experience</h2>
        <hr>
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
        <hr>
        @foreach($education as $edu)
        <div class="entry">
            <div class="entry-header">
                <div>
                    <div class="entry-title">{{ $edu->degree }} in {{ $edu->field_of_study }}</div>
                    <div class="entry-subtitle">{{ $edu->institution }}</div>
                </div>
                <div class="entry-date">{{ $edu->start_date->format('Y') }}@if($edu->end_date) – {{ $edu->end_date->format('Y') }}@endif @if($edu->gpa)| GPA: {{ $edu->gpa }}@endif</div>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    @if($skills->count())
    <div class="section">
        <h2>Skills</h2>
        <hr>
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
        <hr>
        @foreach($projects as $proj)
        <div class="entry">
            <div class="entry-title">{{ $proj->name }}</div>
            @if($proj->description)<p style="font-size:9pt; margin:1pt 0;">{{ $proj->description }}</p>@endif
        </div>
        @endforeach
    </div>
    @endif
</body>
</html>
