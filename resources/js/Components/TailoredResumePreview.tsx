import { cvTemplateStyles, CvTemplateId } from '@/lib/cvTemplates';
import { Education, Project, Skill, User, WorkExperience } from '@/types';

interface PreviewData {
    summary: string;
    experiences: WorkExperience[];
    skills: Skill[];
    education: Education[];
    projects?: Project[];
}

interface Props {
    profile: User;
    data: PreviewData;
    template?: CvTemplateId;
}

const formatMonthYear = (date: string) =>
    new Date(date).toLocaleDateString('en-US', { month: 'short', year: 'numeric' });

export default function TailoredResumePreview({ profile, data, template = 'modern' }: Props) {
    const s = cvTemplateStyles[template];

    const contact = [
        profile.phone,
        profile.email,
        profile.location,
        profile.linkedin_url,
        profile.github_url,
        profile.website,
    ].filter(Boolean);

    const skillGroups = data.skills.reduce<Record<string, Skill[]>>((groups, skill) => {
        const category = skill.category || 'Other';
        groups[category] = [...(groups[category] ?? []), skill];
        return groups;
    }, {});

    return (
        <div className={`rounded-lg border bg-white p-8 shadow-sm ${s.wrapper}`} style={{ minHeight: 800 }}>
            <div className="text-center">
                <h1 className={s.name}>{profile.name}</h1>
                {contact.length > 0 && (
                    <p className={`text-sm ${s.date}`}>{contact.join(' · ')}</p>
                )}
                {profile.title && (
                    <p className={`mt-1 text-sm font-medium ${s.accent}`}>{profile.title}</p>
                )}
            </div>

            <section className="mt-6">
                <h2 className={s.heading}>{s.summaryLabel}</h2>
                <p className={`mt-2 leading-relaxed ${s.body}`}>{data.summary}</p>
            </section>

            {data.experiences.length > 0 && (
                <section className="mt-6">
                    <h2 className={s.heading}>Experience</h2>
                    <div className="mt-4 space-y-4">
                        {data.experiences.map((exp) => (
                            <div key={exp.id}>
                                <div className="flex items-start justify-between gap-4">
                                    <div>
                                        <p className="text-sm font-medium">{exp.position}</p>
                                        <p className={`text-xs ${s.date}`}>
                                            {exp.company}
                                            {exp.location ? `, ${exp.location}` : ''}
                                        </p>
                                    </div>
                                    <p className={`shrink-0 text-xs ${s.date}`}>
                                        {formatMonthYear(exp.start_date)} –{' '}
                                        {exp.is_current || !exp.end_date
                                            ? 'Present'
                                            : formatMonthYear(exp.end_date)}
                                    </p>
                                </div>
                                {exp.description && (
                                    <p className={`mt-1 whitespace-pre-line ${s.muted}`}>{exp.description}</p>
                                )}
                            </div>
                        ))}
                    </div>
                </section>
            )}

            {data.education.length > 0 && (
                <section className="mt-6">
                    <h2 className={s.heading}>Education</h2>
                    <div className="mt-3 space-y-3">
                        {data.education.map((edu) => (
                            <div key={edu.id}>
                                <p className="text-sm font-medium">
                                    {edu.degree}
                                    {edu.field_of_study ? ` in ${edu.field_of_study}` : ''}
                                </p>
                                <p className={`text-xs ${s.date}`}>
                                    {edu.institution}
                                    {edu.gpa ? ` — GPA: ${edu.gpa}` : ''}
                                </p>
                            </div>
                        ))}
                    </div>
                </section>
            )}

            {data.skills.length > 0 && (
                <section className="mt-6">
                    <h2 className={s.heading}>Skills</h2>
                    <div className="mt-2 space-y-1">
                        {Object.entries(skillGroups).map(([category, skills]) => (
                            <p key={category} className={s.muted}>
                                <span className={`font-medium ${s.accent}`}>{category}: </span>
                                {skills.map((skill) => skill.name).join(', ')}
                            </p>
                        ))}
                    </div>
                </section>
            )}

            {data.projects && data.projects.length > 0 && (
                <section className="mt-6">
                    <h2 className={s.heading}>Projects</h2>
                    <div className="mt-3 space-y-3">
                        {data.projects.map((proj) => (
                            <div key={proj.id}>
                                <p className="text-sm font-medium">{proj.name}</p>
                                {proj.description && (
                                    <p className={`line-clamp-2 ${s.muted}`}>{proj.description}</p>
                                )}
                            </div>
                        ))}
                    </div>
                </section>
            )}
        </div>
    );
}
