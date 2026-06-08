import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';
import { Card, CardContent, CardHeader, CardTitle } from '@/Components/ui/card';
import { Badge } from '@/Components/ui/badge';
import { PageProps, CareerSuggestion } from '@/types';

interface Props extends PageProps {
    suggestions: CareerSuggestion[];
}

export default function CareerSuggestions({ suggestions }: Props) {
    const matchColor = (score: number) => {
        if (score >= 85) return 'default';
        if (score >= 70) return 'secondary';
        return 'outline';
    };

    const statusColor = (status: string) => {
        switch (status) {
            case 'matched': return 'default';
            case 'partial': return 'secondary';
            case 'gap': return 'destructive';
            default: return 'outline';
        }
    };

    return (
        <AuthenticatedLayout
            header={<h2 className="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">Career Suggestions</h2>}
        >
            <Head title="Career Suggestions" />
            <div className="py-12">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    {suggestions.length === 0 && (
                        <Card>
                            <CardContent className="flex flex-col items-center py-12">
                                <p className="text-muted-foreground">No career suggestions available. Add more experience and skills to get personalized suggestions.</p>
                            </CardContent>
                        </Card>
                    )}

                    <div className="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                        {suggestions.map((suggestion) => (
                            <Card key={suggestion.id} className="flex flex-col">
                                <CardHeader>
                                    <div className="flex items-start justify-between">
                                        <CardTitle className="text-lg">{suggestion.suggested_role}</CardTitle>
                                        <Badge variant={matchColor(suggestion.match_score)} className="ml-2 shrink-0">
                                            {suggestion.match_score}% match
                                        </Badge>
                                    </div>
                                    <p className="text-sm text-muted-foreground">{suggestion.description}</p>
                                </CardHeader>
                                <CardContent className="flex-1">
                                    {suggestion.progression_path && suggestion.progression_path.length > 0 && (
                                        <div className="mb-4">
                                            <p className="mb-1 text-xs font-semibold uppercase tracking-wider text-muted-foreground">Progression Path</p>
                                            <div className="flex flex-wrap items-center gap-1 text-xs">
                                                {suggestion.progression_path.map((step, i) => (
                                                    <span key={i} className="flex items-center gap-1">
                                                        <span className="rounded bg-gray-100 px-2 py-0.5 dark:bg-gray-800">{step}</span>
                                                        {i < suggestion.progression_path.length - 1 && (
                                                            <span className="text-muted-foreground">→</span>
                                                        )}
                                                    </span>
                                                ))}
                                            </div>
                                        </div>
                                    )}

                                    {suggestion.skill_coverage && suggestion.skill_coverage.length > 0 && (
                                        <div className="mb-4">
                                            <p className="mb-1 text-xs font-semibold uppercase tracking-wider text-muted-foreground">Skill Coverage</p>
                                            <div className="space-y-1">
                                                {suggestion.skill_coverage.map((item, i) => (
                                                    <div key={i} className="flex items-center justify-between text-xs">
                                                        <span>{item.skill}</span>
                                                        <Badge variant={statusColor(item.status)} className="text-[10px]">
                                                            {item.status === 'matched' ? '✓' : item.status === 'partial' ? '~' : '✗'} {item.status}
                                                        </Badge>
                                                    </div>
                                                ))}
                                            </div>
                                        </div>
                                    )}

                                    {suggestion.skill_gaps && suggestion.skill_gaps.length > 0 && (
                                        <div>
                                            <p className="mb-1 text-xs font-semibold uppercase tracking-wider text-muted-foreground">Skill Gaps to Address</p>
                                            <div className="flex flex-wrap gap-1">
                                                {suggestion.skill_gaps.map((gap, i) => (
                                                    <Badge key={i} variant="destructive" className="text-[10px]">
                                                        {gap}
                                                    </Badge>
                                                ))}
                                            </div>
                                        </div>
                                    )}
                                </CardContent>
                            </Card>
                        ))}
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
