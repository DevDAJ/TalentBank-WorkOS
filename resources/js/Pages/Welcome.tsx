import { PageProps } from '@/types';
import { Head, Link } from '@inertiajs/react';
import { Button } from '@/Components/ui/button';
import { FileText, Sparkles, BarChart3, Palette, Download, ArrowRight } from 'lucide-react';

export default function Welcome({
    auth,
    laravelVersion,
    phpVersion,
}: PageProps<{ laravelVersion: string; phpVersion: string }>) {
    return (
        <>
            <Head title="Welcome" />
            <div className="flex min-h-screen flex-col">
                {/* Nav */}
                <nav className="fixed top-0 z-50 w-full border-b bg-white/80 backdrop-blur dark:border-gray-800 dark:bg-gray-950/80">
                    <div className="mx-auto flex h-16 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
                        <div className="flex items-center gap-2">
                            <div className="flex h-8 w-8 items-center justify-center rounded-lg bg-primary">
                                <FileText className="h-4 w-4 text-white" />
                            </div>
                            <span className="text-lg font-bold">CV Generator</span>
                        </div>
                        <div className="flex items-center gap-4">
                            {auth.user ? (
                                <Link href={route('dashboard')}>
                                    <Button>Dashboard</Button>
                                </Link>
                            ) : (
                                <>
                                    <Link href={route('login')}>
                                        <Button variant="ghost">Log in</Button>
                                    </Link>
                                    <Link href={route('register')}>
                                        <Button>Get Started</Button>
                                    </Link>
                                </>
                            )}
                        </div>
                    </div>
                </nav>

                {/* Hero */}
                <section className="relative flex flex-1 items-center justify-center pt-16">
                    <div className="absolute inset-0 -z-10 bg-[radial-gradient(45%_40%_at_50%_60%,hsl(var(--primary)/0.06),transparent)]" />
                    <div className="mx-auto max-w-5xl px-4 py-24 text-center sm:px-6 lg:px-8">
                        <div className="mx-auto inline-flex items-center gap-2 rounded-full border bg-muted px-4 py-1.5 text-sm text-muted-foreground">
                            <Sparkles className="h-4 w-4 text-primary" />
                            AI-Powered Resume Builder
                        </div>
                        <h1 className="mt-8 text-4xl font-bold tracking-tight sm:text-5xl lg:text-6xl">
                            Craft Resumes That
                            <span className="block text-primary">Get You Hired</span>
                        </h1>
                        <p className="mx-auto mt-6 max-w-2xl text-lg text-muted-foreground">
                            Build ATS-friendly CVs, tailor them to any job description,
                            discover career paths, and check salary fairness — all in one place.
                        </p>
                        <div className="mt-10 flex items-center justify-center gap-4">
                            {auth.user ? (
                                <Link href={route('dashboard')}>
                                    <Button size="lg">Go to Dashboard <ArrowRight className="ml-2 h-4 w-4" /></Button>
                                </Link>
                            ) : (
                                <>
                                    <Link href={route('register')}>
                                        <Button size="lg">Get Started Free <ArrowRight className="ml-2 h-4 w-4" /></Button>
                                    </Link>
                                    <Link href={route('login')}>
                                        <Button variant="outline" size="lg">Sign In</Button>
                                    </Link>
                                </>
                            )}
                        </div>
                    </div>
                </section>

                {/* Features */}
                <section className="border-t bg-muted/30 py-20 dark:border-gray-800">
                    <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                        <div className="text-center">
                            <h2 className="text-3xl font-bold">Everything You Need</h2>
                            <p className="mt-2 text-muted-foreground">Built for job seekers who want to stand out.</p>
                        </div>
                        <div className="mt-16 grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                            <div className="rounded-xl border bg-card p-6">
                                <div className="flex h-10 w-10 items-center justify-center rounded-lg bg-primary/10">
                                    <FileText className="h-5 w-5 text-primary" />
                                </div>
                                <h3 className="mt-4 text-lg font-semibold">Multiple Templates</h3>
                                <p className="mt-2 text-sm text-muted-foreground">Classic, Modern, and Minimal layouts — each optimized for ATS parsing with clean typography.</p>
                            </div>
                            <div className="rounded-xl border bg-card p-6">
                                <div className="flex h-10 w-10 items-center justify-center rounded-lg bg-primary/10">
                                    <Sparkles className="h-5 w-5 text-primary" />
                                </div>
                                <h3 className="mt-4 text-lg font-semibold">Tailored Resumes</h3>
                                <p className="mt-2 text-sm text-muted-foreground">Paste a job description and get a customized resume with keyword matching and relevance scoring.</p>
                            </div>
                            <div className="rounded-xl border bg-card p-6">
                                <div className="flex h-10 w-10 items-center justify-center rounded-lg bg-primary/10">
                                    <BarChart3 className="h-5 w-5 text-primary" />
                                </div>
                                <h3 className="mt-4 text-lg font-semibold">Salary Insights</h3>
                                <p className="mt-2 text-sm text-muted-foreground">Check if your expected salary is on target with market benchmarks for your role and seniority.</p>
                            </div>
                            <div className="rounded-xl border bg-card p-6">
                                <div className="flex h-10 w-10 items-center justify-center rounded-lg bg-primary/10">
                                    <Palette className="h-5 w-5 text-primary" />
                                </div>
                                <h3 className="mt-4 text-lg font-semibold">Career Suggestions</h3>
                                <p className="mt-2 text-sm text-muted-foreground">Discover career paths based on your current skills and experience with match scores.</p>
                            </div>
                            <div className="rounded-xl border bg-card p-6">
                                <div className="flex h-10 w-10 items-center justify-center rounded-lg bg-primary/10">
                                    <Download className="h-5 w-5 text-primary" />
                                </div>
                                <h3 className="mt-4 text-lg font-semibold">PDF Export</h3>
                                <p className="mt-2 text-sm text-muted-foreground">Download your CV as a clean, ATS-parseable PDF with proper fonts and layout.</p>
                            </div>
                            <div className="rounded-xl border bg-card p-6">
                                <div className="flex h-10 w-10 items-center justify-center rounded-lg bg-primary/10">
                                    <FileText className="h-5 w-5 text-primary" />
                                </div>
                                <h3 className="mt-4 text-lg font-semibold">Profile Management</h3>
                                <p className="mt-2 text-sm text-muted-foreground">Manage your experience, education, skills, projects, and certifications all in one place.</p>
                            </div>
                        </div>
                    </div>
                </section>

                {/* Footer */}
                <footer className="border-t py-8 dark:border-gray-800">
                    <div className="mx-auto flex max-w-7xl items-center justify-between px-4 text-sm text-muted-foreground sm:px-6 lg:px-8">
                        <p>&copy; 2026 CV Generator.</p>
                        <p>Laravel v{laravelVersion} &middot; PHP v{phpVersion}</p>
                    </div>
                </footer>
            </div>
        </>
    );
}
