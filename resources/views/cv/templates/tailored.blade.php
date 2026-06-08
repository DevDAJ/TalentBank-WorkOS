<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 10.5pt; line-height: 1.5; color: #1a1a1a; margin: 1in; }
        h1 { font-size: 20pt; margin: 0 0 2pt 0; color: #2563eb; }
        .contact { font-size: 9.5pt; margin-bottom: 14pt; color: #555; }
        h2 { font-size: 12pt; color: #2563eb; border-bottom: 1.5px solid #2563eb; padding-bottom: 2pt; margin: 12pt 0 6pt 0; }
        .entry { margin-bottom: 8pt; }
        .entry-header { display: flex; justify-content: space-between; }
        .entry-title { font-weight: bold; font-size: 11pt; }
        .entry-subtitle { font-size: 10pt; color: #444; }
        .entry-date { font-size: 9.5pt; color: #777; text-align: right; white-space: nowrap; }
        .entry-desc { font-size: 9.5pt; margin: 3pt 0 0 0; white-space: pre-line; color: #333; }
        .skill-group { margin-bottom: 4pt; font-size: 9.5pt; }
        .section { page-break-inside: avoid; }
    </style>
</head>
<body>
    <h1>{{ $profile->name }}</h1>
    <div class="contact">
        @if($profile->phone){{ $profile->phone }} &bull; @endif
        {{ $profile->email }}
        @if($profile->location) &bull; {{ $profile->location }} @endif
        @if($profile->linkedin_url) &bull; {{ $profile->linkedin_url }} @endif
    </div>

    <div class="section">
        <h2>Summary</h2>
        <p style="font-size:9.5pt;">{{ $data['summary'] ?? $profile->summary }}</p>
    </div>

    <div class="section">
        <h2>Experience</h2>
        @foreach($data['experiences'] ?? [] as $exp)
        <div class="entry">
            <div class="entry-header">
                <div>
                    <div class="entry-title">{{ $exp['position'] }}</div>
                    <div class="entry-subtitle">{{ $exp['company'] }}@if(!empty($exp['location'])), {{ $exp['location'] }}@endif</div>
                </div>
                <div class="entry-date">{{ \Carbon\Carbon::parse($exp['start_date'])->format('M Y') }} – {{ !empty($exp['end_date']) ? \Carbon\Carbon::parse($exp['end_date'])->format('M Y') : 'Present' }}</div>
            </div>
            @if(!empty($exp['description']))
            <div class="entry-desc">{{ $exp['description'] }}</div>
            @endif
        </div>
        @endforeach
    </div>

    @if(count($data['education'] ?? []))
    <div class="section">
        <h2>Education</h2>
        @foreach($data['education'] as $edu)
        <div class="entry">
            <div class="entry-header">
                <div>
                    <div class="entry-title">{{ $edu['degree'] }}{{ !empty($edu['field_of_study']) ? ' in '.$edu['field_of_study'] : '' }}</div>
                    <div class="entry-subtitle">{{ $edu['institution'] }}</div>
                </div>
                <div class="entry-date">{{ \Carbon\Carbon::parse($edu['start_date'])->format('Y') }}@if(!empty($edu['end_date'])) – {{ \Carbon\Carbon::parse($edu['end_date'])->format('Y') }}@endif</div>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    @if(count($data['skills'] ?? []))
    <div class="section">
        <h2>Skills</h2>
        @php $groups = collect($data['skills'])->groupBy('category'); @endphp
        @foreach($groups as $category => $catSkills)
        <div class="skill-group">
            <strong>{{ $category }}:</strong> {{ collect($catSkills)->pluck('name')->join(', ') }}
        </div>
        @endforeach
    </div>
    @endif
</body>
</html>
