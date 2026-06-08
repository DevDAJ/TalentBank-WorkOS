import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import TailoredResumePreview from '@/Components/TailoredResumePreview';
import { cvTemplates, CvTemplateId } from '@/lib/cvTemplates';
import { Head, router, usePage } from '@inertiajs/react';
import { Button } from '@/Components/ui/button';
import { Input } from '@/Components/ui/input';
import { Label } from '@/Components/ui/label';
import { Textarea } from '@/Components/ui/textarea';
import { Card, CardContent, CardHeader, CardTitle } from '@/Components/ui/card';
import { Badge } from '@/Components/ui/badge';
import { PageProps } from '@/types';
import { FormEvent, useState } from 'react';

interface GeneratedData {
    job_title: string;
    company_name: string;
    summary: string;
    experiences: any[];
    skills: any[];
    education: any[];
    projects: any[];
    match_score: number;
    matched_keywords: string[];
    missing_keywords: string[];
    salary_analysis: {
        input_salary: number;
        p25: number;
        p50: number;
        p75: number;
        verdict: string;
    } | null;
}

interface Props extends PageProps {
    generated: GeneratedData | null;
}

export default function TailoredResume({ generated }: Props) {
    const user = usePage().props.auth.user;
    const [jobTitle, setJobTitle] = useState('');
    const [companyName, setCompanyName] = useState('');
    const [jobDescription, setJobDescription] = useState('');
    const [expectedSalary, setExpectedSalary] = useState('');
    const [loading, setLoading] = useState(false);
    const [selectedTemplate, setSelectedTemplate] = useState<CvTemplateId>('modern');

    const generateResume = async (e: FormEvent) => {
        e.preventDefault();
        setLoading(true);
        router.post(route('tailored.generate'), {
            job_title: jobTitle,
            company_name: companyName,
            job_description: jobDescription,
            expected_salary: expectedSalary ? parseFloat(expectedSalary) : null,
        }, {
            onFinish: () => setLoading(false),
        });
    };

    const downloadPdf = () => {
        if (!generated) return;
        window.location.href = route('tailored.download', { template: selectedTemplate });
    };

    const selectedTemplateName = cvTemplates.find((t) => t.id === selectedTemplate)?.name;

    const verdictColor = (v: string) => {
        switch (v) {
            case 'below_market': return 'destructive';
            case 'on_target': return 'default';
            case 'above_market': return 'secondary';
            default: return 'outline';
        }
    };

    const verdictLabel = (v: string) => {
        switch (v) {
            case 'below_market': return 'Below Market';
            case 'on_target': return 'On Target';
            case 'above_market': return 'Above Market';
            default: return 'Unknown';
        }
    };

    return (
        <AuthenticatedLayout
            header={<h2 className="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">Tailored Resume</h2>}
        >
            <Head title="Tailored Resume" />
            <div className="py-12">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    {!generated ? (
                        <Card>
                            <CardHeader>
                                <CardTitle>Generate a Tailored Resume</CardTitle>
                            </CardHeader>
                            <CardContent>
                                <form onSubmit={generateResume} className="space-y-4">
                                    <div className="grid gap-4 md:grid-cols-2">
                                        <div className="space-y-2">
                                            <Label>Job Title</Label>
                                            <Input value={jobTitle} onChange={(e) => setJobTitle(e.target.value)} placeholder="e.g. Senior Frontend Engineer" required />
                                        </div>
                                        <div className="space-y-2">
                                            <Label>Company (optional)</Label>
                                            <Input value={companyName} onChange={(e) => setCompanyName(e.target.value)} placeholder="e.g. Acme Corp" />
                                        </div>
                                    </div>
                                    <div className="space-y-2">
                                        <Label>Job Description</Label>
                                        <Textarea
                                            value={jobDescription}
                                            onChange={(e) => setJobDescription(e.target.value)}
                                            rows={10}
                                            placeholder="Paste the full job description here..."
                                            required
                                        />
                                    </div>
                                    <div className="space-y-2">
                                        <Label>Expected Salary (optional — for fairness check)</Label>
                                        <Input type="number" value={expectedSalary} onChange={(e) => setExpectedSalary(e.target.value)} placeholder="e.g. 150000" />
                                    </div>
                                    <Button disabled={loading}>{loading ? 'Generating...' : 'Generate Tailored Resume'}</Button>
                                </form>
                            </CardContent>
                        </Card>
                    ) : (
                        <div className="space-y-6">
                            <div className="flex items-center justify-between">
                                <div>
                                    <h3 className="text-lg font-semibold">Resume for {generated.job_title}</h3>
                                    {generated.company_name && (
                                        <p className="text-sm text-muted-foreground">{generated.company_name}</p>
                                    )}
                                </div>
                                <Button onClick={downloadPdf}>
                                    Download {selectedTemplateName} PDF
                                </Button>
                            </div>

                            <div className="grid gap-6 lg:grid-cols-3">
                                <div className="space-y-6 lg:col-span-1">
                                    <Card>
                                        <CardHeader>
                                            <CardTitle className="text-lg">Template</CardTitle>
                                        </CardHeader>
                                        <CardContent>
                                            <div className="space-y-3">
                                                {cvTemplates.map((t) => (
                                                    <button
                                                        key={t.id}
                                                        type="button"
                                                        onClick={() => setSelectedTemplate(t.id)}
                                                        className={`w-full rounded-lg border p-3 text-left transition-colors ${
                                                            selectedTemplate === t.id
                                                                ? 'border-primary bg-primary/5'
                                                                : 'hover:border-gray-300'
                                                        }`}
                                                    >
                                                        <div className="font-medium">{t.name}</div>
                                                        <div className="text-xs text-muted-foreground">{t.description}</div>
                                                        <div className="mt-1 text-xs text-muted-foreground">Font: {t.font}</div>
                                                    </button>
                                                ))}
                                            </div>
                                        </CardContent>
                                    </Card>

                                    <Card>
                                        <CardHeader>
                                            <CardTitle className="text-lg">Match Score</CardTitle>
                                        </CardHeader>
                                        <CardContent>
                                            <div className="mb-2 flex items-baseline gap-2">
                                                <span className="text-4xl font-bold">{generated.match_score}%</span>
                                                <Badge variant={generated.match_score >= 70 ? 'default' : 'secondary'}>
                                                    {generated.match_score >= 70 ? 'Strong Match' : 'Partial Match'}
                                                </Badge>
                                            </div>
                                            <div className="mb-4 h-3 w-full rounded-full bg-gray-200 dark:bg-gray-700">
                                                <div className="h-3 rounded-full bg-primary transition-all" style={{ width: `${generated.match_score}%` }} />
                                            </div>

                                            <div className="mb-3">
                                                <p className="mb-1 text-xs font-semibold uppercase text-muted-foreground">Matched Keywords</p>
                                                <div className="flex flex-wrap gap-1">
                                                    {generated.matched_keywords.map((kw) => (
                                                        <Badge key={kw} variant="default" className="text-[10px]">{kw}</Badge>
                                                    ))}
                                                </div>
                                            </div>

                                            {generated.missing_keywords.length > 0 && (
                                                <div>
                                                    <p className="mb-1 text-xs font-semibold uppercase text-muted-foreground">Missing Keywords</p>
                                                    <div className="flex flex-wrap gap-1">
                                                        {generated.missing_keywords.map((kw) => (
                                                            <Badge key={kw} variant="destructive" className="text-[10px]">{kw}</Badge>
                                                        ))}
                                                    </div>
                                                </div>
                                            )}
                                        </CardContent>
                                    </Card>

                                    {generated.salary_analysis && (
                                        <Card>
                                            <CardHeader>
                                                <CardTitle className="text-lg">Salary Fairness Check</CardTitle>
                                            </CardHeader>
                                            <CardContent>
                                                <div className="space-y-3">
                                                    <div className="flex items-center justify-between">
                                                        <span className="text-sm text-muted-foreground">Your Expected</span>
                                                        <span className="font-semibold">${generated.salary_analysis.input_salary.toLocaleString()}</span>
                                                    </div>
                                                    <div className="flex items-center justify-between">
                                                        <span className="text-sm text-muted-foreground">Market Range</span>
                                                        <span className="text-sm">${generated.salary_analysis.p25.toLocaleString()} – ${generated.salary_analysis.p75.toLocaleString()}</span>
                                                    </div>
                                                    <div className="flex items-center justify-between">
                                                        <span className="text-sm text-muted-foreground">Median (P50)</span>
                                                        <span className="font-semibold">${generated.salary_analysis.p50.toLocaleString()}</span>
                                                    </div>
                                                    <div className="flex items-center justify-between border-t pt-2">
                                                        <span className="text-sm font-medium">Verdict</span>
                                                        <Badge variant={verdictColor(generated.salary_analysis.verdict)}>
                                                            {verdictLabel(generated.salary_analysis.verdict)}
                                                        </Badge>
                                                    </div>
                                                </div>
                                            </CardContent>
                                        </Card>
                                    )}
                                </div>

                                <div className="lg:col-span-2">
                                    <Card>
                                        <CardHeader>
                                            <CardTitle className="text-lg">Preview — {selectedTemplateName}</CardTitle>
                                        </CardHeader>
                                        <CardContent>
                                            <TailoredResumePreview
                                                profile={user}
                                                template={selectedTemplate}
                                                data={{
                                                    summary: generated.summary,
                                                    experiences: generated.experiences,
                                                    skills: generated.skills,
                                                    education: generated.education,
                                                    projects: generated.projects,
                                                }}
                                            />
                                        </CardContent>
                                    </Card>
                                </div>
                            </div>

                            {generated.projects.length > 0 && (
                                <Card>
                                    <CardHeader>
                                        <CardTitle className="text-lg">Projects</CardTitle>
                                    </CardHeader>
                                    <CardContent>
                                        <div className="grid gap-3 md:grid-cols-2">
                                            {generated.projects.map((proj: any) => (
                                                <div key={proj.id} className="rounded-lg border p-3">
                                                    <p className="font-medium text-sm">{proj.name}</p>
                                                    {proj.description && <p className="mt-1 text-xs text-muted-foreground line-clamp-2">{proj.description}</p>}
                                                    {proj.technologies_used && proj.technologies_used.length > 0 && (
                                                        <div className="mt-2 flex flex-wrap gap-1">
                                                            {proj.technologies_used.map((tech: string) => <Badge key={tech} variant="outline" className="text-[10px]">{tech}</Badge>)}
                                                        </div>
                                                    )}
                                                </div>
                                            ))}
                                        </div>
                                    </CardContent>
                                </Card>
                            )}

                            <div className="flex justify-center">
                                <Button variant="outline" onClick={() => router.get(route('tailored.index'))}>
                                    Start Over
                                </Button>
                            </div>
                        </div>
                    )}
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
