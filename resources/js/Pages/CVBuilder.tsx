import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { cvTemplates, cvTemplateStyles, CvTemplateId } from '@/lib/cvTemplates';
import { Head } from '@inertiajs/react';
import { Button } from '@/Components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/Components/ui/card';
import { Badge } from '@/Components/ui/badge';
import { PageProps, WorkExperience, Education, Skill, Project } from '@/types';
import { useState } from 'react';

interface Props extends PageProps {
    profile: any;
    experiences: WorkExperience[];
    education: Education[];
    skills: Skill[];
    projects: Project[];
}

export default function CVBuilder({ profile, experiences, education, skills, projects }: Props) {
    const [selectedTemplate, setSelectedTemplate] = useState<CvTemplateId>('modern');
    const [sectionOrder, setSectionOrder] = useState(['summary', 'experience', 'education', 'skills', 'projects']);

    const moveSection = (index: number, direction: 'up' | 'down') => {
        const newOrder = [...sectionOrder];
        const swapIndex = direction === 'up' ? index - 1 : index + 1;
        if (swapIndex < 0 || swapIndex >= newOrder.length) return;
        [newOrder[index], newOrder[swapIndex]] = [newOrder[swapIndex], newOrder[index]];
        setSectionOrder(newOrder);
    };

    const downloadPdf = () => {
        window.location.href = route('cv.preview', { template: selectedTemplate });
    };

    const sectionLabels: Record<string, string> = {
        summary: 'Professional Summary',
        experience: 'Experience',
        education: 'Education',
        skills: 'Skills',
        projects: 'Projects',
    };

    const s = cvTemplateStyles[selectedTemplate];

    return (
        <AuthenticatedLayout
            header={<h2 className="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">CV Builder</h2>}
        >
            <Head title="CV Builder" />
            <div className="py-12">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
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
                                    <CardTitle className="text-lg">Section Order</CardTitle>
                                </CardHeader>
                                <CardContent>
                                    <div className="space-y-2">
                                        {sectionOrder.map((section, idx) => (
                                            <div key={section} className="flex items-center justify-between rounded border p-2">
                                                <span className="text-sm">{sectionLabels[section]}</span>
                                                <div className="flex gap-1">
                                                    <button
                                                        onClick={() => moveSection(idx, 'up')}
                                                        disabled={idx === 0}
                                                        className="rounded p-1 text-xs hover:bg-gray-100 disabled:opacity-30"
                                                    >↑</button>
                                                    <button
                                                        onClick={() => moveSection(idx, 'down')}
                                                        disabled={idx === sectionOrder.length - 1}
                                                        className="rounded p-1 text-xs hover:bg-gray-100 disabled:opacity-30"
                                                    >↓</button>
                                                </div>
                                            </div>
                                        ))}
                                    </div>
                                </CardContent>
                            </Card>

                            <Button className="w-full" onClick={downloadPdf}>
                                Download {cvTemplates.find((t) => t.id === selectedTemplate)?.name} PDF
                            </Button>
                        </div>

                        <div className="lg:col-span-2">
                            <Card>
                                <CardHeader>
                                    <CardTitle className="text-lg">Preview — {cvTemplates.find((t) => t.id === selectedTemplate)?.name}</CardTitle>
                                </CardHeader>
                                <CardContent>
                                    <div className={`rounded-lg border bg-white p-8 shadow-sm ${s.wrapper}`} style={{ minHeight: 800 }}>
                                        <div className="text-center">
                                            <h1 className={s.name}>{profile.name}</h1>
                                            <p className={`text-sm ${s.date}`}>
                                                {[profile.email, profile.phone, profile.location].filter(Boolean).join(' · ')}
                                            </p>
                                            {profile.title && (
                                                <p className={`mt-1 text-sm font-medium ${s.accent}`}>{profile.title}</p>
                                            )}
                                        </div>

                                        {sectionOrder.map((section) => {
                                            switch (section) {
                                                case 'summary':
                                                    return profile.summary ? (
                                                        <div key={section} className="mt-6">
                                                            <h2 className={s.heading}>{s.summaryLabel}</h2>
                                                            <p className={`mt-2 leading-relaxed ${s.body}`}>{profile.summary}</p>
                                                        </div>
                                                    ) : null;

                                                case 'experience':
                                                    return experiences.length > 0 ? (
                                                        <div key={section} className="mt-6">
                                                            <h2 className={s.heading}>Experience</h2>
                                                            {experiences.map((exp) => (
                                                                <div key={exp.id} className="mt-4">
                                                                    <div className="flex items-start justify-between">
                                                                        <div>
                                                                            <p className="text-sm font-medium">{exp.position}</p>
                                                                            <p className={`text-xs ${s.date}`}>{exp.company}{exp.location ? `, ${exp.location}` : ''}</p>
                                                                        </div>
                                                                        <p className={`text-xs ${s.date}`}>
                                                                            {new Date(exp.start_date).toLocaleDateString('en-US', { month: 'short', year: 'numeric' })} –
                                                                            {exp.is_current ? ' Present' : new Date(exp.end_date!).toLocaleDateString('en-US', { month: 'short', year: 'numeric' })}
                                                                        </p>
                                                                    </div>
                                                                    {exp.description && (
                                                                        <p className={`mt-1 whitespace-pre-line line-clamp-3 ${s.muted}`}>{exp.description}</p>
                                                                    )}
                                                                </div>
                                                            ))}
                                                        </div>
                                                    ) : null;

                                                case 'education':
                                                    return education.length > 0 ? (
                                                        <div key={section} className="mt-6">
                                                            <h2 className={s.heading}>Education</h2>
                                                            {education.map((edu) => (
                                                                <div key={edu.id} className="mt-3">
                                                                    <p className="text-sm font-medium">{edu.degree}{edu.field_of_study ? ` in ${edu.field_of_study}` : ''}</p>
                                                                    <p className={`text-xs ${s.date}`}>{edu.institution}{edu.gpa ? ` — GPA: ${edu.gpa}` : ''}</p>
                                                                </div>
                                                            ))}
                                                        </div>
                                                    ) : null;

                                                case 'skills':
                                                    return skills.length > 0 ? (
                                                        <div key={section} className="mt-6">
                                                            <h2 className={s.heading}>Skills</h2>
                                                            {(['Technical', 'Design', 'Soft', 'Language', 'Tool'] as const).map((cat) => {
                                                                const catSkills = skills.filter((s) => s.category === cat);
                                                                if (catSkills.length === 0) return null;
                                                                return (
                                                                    <div key={cat} className={`mt-1 ${s.muted}`}>
                                                                        <span className={`font-medium ${s.accent}`}>{cat}: </span>
                                                                        {catSkills.map((skill) => skill.name).join(', ')}
                                                                    </div>
                                                                );
                                                            })}
                                                        </div>
                                                    ) : null;

                                                case 'projects':
                                                    return projects.length > 0 ? (
                                                        <div key={section} className="mt-6">
                                                            <h2 className={s.heading}>Projects</h2>
                                                            {projects.map((proj) => (
                                                                <div key={proj.id} className="mt-3">
                                                                    <p className="text-sm font-medium">{proj.name}</p>
                                                                    {proj.description && <p className={`line-clamp-2 ${s.muted}`}>{proj.description}</p>}
                                                                </div>
                                                            ))}
                                                        </div>
                                                    ) : null;

                                                default:
                                                    return null;
                                            }
                                        })}
                                    </div>
                                </CardContent>
                            </Card>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
