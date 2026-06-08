import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, usePage } from '@inertiajs/react';
import { Card, CardContent, CardHeader, CardTitle } from '@/Components/ui/card';
import { Badge } from '@/Components/ui/badge';
import { Button } from '@/Components/ui/button';
import { PageProps, Skill, WorkExperience } from '@/types';
import { useEffect, useState } from 'react';
import axios from 'axios';

interface DashboardProps extends PageProps {
    skills: Skill[];
    experiences: WorkExperience[];
}

export default function Dashboard({ skills, experiences }: DashboardProps) {
    const user = usePage().props.auth.user;
    const [salaryData, setSalaryData] = useState<{
        found: boolean;
        role_title?: string;
        company?: string;
    }>({ found: false });

    useEffect(() => {
        axios.get(route('salary.current-role')).then((res) => {
            if (res.data.found) {
                setSalaryData(res.data);
            }
        });
    }, []);

    const profileFields = [user.title, user.phone, user.location, user.summary, user.linkedin_url, user.github_url];
    const filledFields = profileFields.filter(Boolean).length;
    const completeness = Math.round((filledFields / profileFields.length) * 100);
    const hasSkills = skills && skills.length > 0;
    const hasExperience = experiences && experiences.length > 0;

    return (
        <AuthenticatedLayout
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    Dashboard
                </h2>
            }
        >
            <Head title="Dashboard" />

            <div className="py-12">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div className="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                        <Card>
                            <CardHeader>
                                <CardTitle className="text-lg">Profile Completeness</CardTitle>
                            </CardHeader>
                            <CardContent>
                                <div className="mb-2 flex items-baseline justify-between">
                                    <span className="text-3xl font-bold">{completeness}%</span>
                                    <Badge variant={completeness >= 80 ? 'default' : completeness >= 50 ? 'secondary' : 'outline'}>
                                        {completeness >= 80 ? 'Great' : completeness >= 50 ? 'Good' : 'Needs Work'}
                                    </Badge>
                                </div>
                                <div className="mb-4 h-2 w-full rounded-full bg-gray-200 dark:bg-gray-700">
                                    <div className="h-2 rounded-full bg-primary transition-all" style={{ width: `${completeness}%` }} />
                                </div>
                                <p className="text-sm text-muted-foreground">
                                    {filledFields} of {profileFields.length} fields filled
                                </p>
                                <div className="mt-4">
                                    <Link href={route('profile.edit')}>
                                        <Button variant="outline" size="sm">Complete Profile</Button>
                                    </Link>
                                </div>
                            </CardContent>
                        </Card>

                        <Card>
                            <CardHeader>
                                <CardTitle className="text-lg">Quick Stats</CardTitle>
                            </CardHeader>
                            <CardContent>
                                <div className="space-y-3">
                                    <div className="flex items-center justify-between">
                                        <span className="text-sm text-muted-foreground">Work Experiences</span>
                                        <span className="font-semibold">{experiences?.length ?? 0}</span>
                                    </div>
                                    <div className="flex items-center justify-between">
                                        <span className="text-sm text-muted-foreground">Skills</span>
                                        <span className="font-semibold">{skills?.length ?? 0}</span>
                                    </div>
                                    <div className="flex items-center justify-between">
                                        <span className="text-sm text-muted-foreground">Has Experience</span>
                                        <Badge variant={hasExperience ? 'default' : 'secondary'}>{hasExperience ? 'Yes' : 'No'}</Badge>
                                    </div>
                                    <div className="flex items-center justify-between">
                                        <span className="text-sm text-muted-foreground">Has Skills</span>
                                        <Badge variant={hasSkills ? 'default' : 'secondary'}>{hasSkills ? 'Yes' : 'No'}</Badge>
                                    </div>
                                </div>
                            </CardContent>
                        </Card>

                        <Card>
                            <CardHeader>
                                <CardTitle className="text-lg">Salary Snapshot</CardTitle>
                            </CardHeader>
                            <CardContent>
                                {salaryData.found ? (
                                    <div>
                                        <p className="text-sm text-muted-foreground">Current Role</p>
                                        <p className="font-semibold">{salaryData.role_title}</p>
                                        <p className="text-xs text-muted-foreground">{salaryData.company}</p>
                                        <div className="mt-4">
                                            <Link href={route('tailored.index')}>
                                                <Button variant="outline" size="sm">Check Fairness</Button>
                                            </Link>
                                        </div>
                                    </div>
                                ) : (
                                    <div>
                                        <p className="text-sm text-muted-foreground">No current role detected.</p>
                                        <p className="text-xs text-muted-foreground mt-1">Add work experience to see salary insights.</p>
                                        <div className="mt-4">
                                            <Link href={route('profile.edit')}>
                                                <Button variant="outline" size="sm">Add Experience</Button>
                                            </Link>
                                        </div>
                                    </div>
                                )}
                            </CardContent>
                        </Card>

                        <Card>
                            <CardHeader>
                                <CardTitle className="text-lg">CV Builder</CardTitle>
                            </CardHeader>
                            <CardContent>
                                <p className="mb-4 text-sm text-muted-foreground">
                                    Generate an ATS-friendly CV with 3 template options.
                                </p>
                                <Link href={route('cv.index')}>
                                    <Button size="sm">Build CV</Button>
                                </Link>
                            </CardContent>
                        </Card>

                        <Card>
                            <CardHeader>
                                <CardTitle className="text-lg">Career Paths</CardTitle>
                            </CardHeader>
                            <CardContent>
                                <p className="mb-4 text-sm text-muted-foreground">
                                    Discover suggested career paths based on your experience and skills.
                                </p>
                                <Link href={route('career.index')}>
                                    <Button size="sm">View Suggestions</Button>
                                </Link>
                            </CardContent>
                        </Card>

                        <Card>
                            <CardHeader>
                                <CardTitle className="text-lg">Tailored Resume</CardTitle>
                            </CardHeader>
                            <CardContent>
                                <p className="mb-4 text-sm text-muted-foreground">
                                    Create a customized resume for a specific job description.
                                </p>
                                <Link href={route('tailored.index')}>
                                    <Button size="sm">Create Resume</Button>
                                </Link>
                            </CardContent>
                        </Card>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
