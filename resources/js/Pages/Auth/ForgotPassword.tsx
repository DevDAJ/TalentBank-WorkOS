import { Button } from '@/Components/ui/button';
import { Input } from '@/Components/ui/input';
import { Label } from '@/Components/ui/label';
import { Card, CardContent, CardHeader, CardTitle } from '@/Components/ui/card';
import InputError from '@/Components/InputError';
import { Head, Link, useForm } from '@inertiajs/react';
import { FormEventHandler } from 'react';
import { FileText } from 'lucide-react';

export default function ForgotPassword({ status }: { status?: string }) {
    const { data, setData, post, processing, errors } = useForm({
        email: '',
    });

    const submit: FormEventHandler = (e) => {
        e.preventDefault();

        post(route('password.email'));
    };

    return (
        <div className="flex min-h-screen">
            <Head title="Forgot Password" />

            {/* Left - Branding */}
            <div className="hidden flex-1 flex-col justify-between bg-gradient-to-br from-primary to-blue-700 p-12 text-white lg:flex">
                <div className="flex items-center gap-3">
                    <div className="flex h-10 w-10 items-center justify-center rounded-lg bg-white/20">
                        <FileText className="h-6 w-6" />
                    </div>
                    <span className="text-xl font-bold">CV Generator</span>
                </div>
                <div className="max-w-md">
                    <h1 className="text-4xl font-bold leading-tight">Build ATS-Friendly Resumes in Minutes</h1>
                    <p className="mt-4 text-lg text-white/80">Create tailored, professional CVs with AI-powered suggestions and salary insights.</p>
                    <div className="mt-8 space-y-4">
                        <div className="flex items-center gap-3">
                            <div className="flex h-8 w-8 items-center justify-center rounded-full bg-white/20 text-sm font-bold">1</div>
                            <span>Build your profile with experience, skills & projects</span>
                        </div>
                        <div className="flex items-center gap-3">
                            <div className="flex h-8 w-8 items-center justify-center rounded-full bg-white/20 text-sm font-bold">2</div>
                            <span>Choose from Classic, Modern, or Minimal templates</span>
                        </div>
                        <div className="flex items-center gap-3">
                            <div className="flex h-8 w-8 items-center justify-center rounded-full bg-white/20 text-sm font-bold">3</div>
                            <span>Tailor resumes to job descriptions & check salary fairness</span>
                        </div>
                    </div>
                </div>
                <p className="text-sm text-white/60">&copy; 2026 CV Generator. All rights reserved.</p>
            </div>

            {/* Right - Form */}
            <div className="flex flex-1 items-center justify-center px-6">
                <Card className="w-full max-w-md border-0 shadow-none">
                    <CardHeader className="text-center">
                        <div className="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-lg bg-primary/10 lg:hidden">
                            <FileText className="h-7 w-7 text-primary" />
                        </div>
                        <CardTitle className="text-2xl font-bold">Forgot your password?</CardTitle>
                        <p className="mt-1 text-sm text-muted-foreground">
                            Enter your email and we&apos;ll send you a link to reset your password.
                        </p>
                    </CardHeader>
                    <CardContent>
                        {status && (
                            <div className="mb-4 text-sm font-medium text-green-600">{status}</div>
                        )}

                        <form onSubmit={submit} className="space-y-4">
                            <div className="space-y-2">
                                <Label htmlFor="email">Email</Label>
                                <Input
                                    id="email"
                                    type="email"
                                    value={data.email}
                                    onChange={(e) => setData('email', e.target.value)}
                                    placeholder="you@example.com"
                                    required
                                    autoFocus
                                />
                                <InputError message={errors.email} />
                            </div>

                            <Button type="submit" className="w-full" disabled={processing}>
                                {processing ? 'Sending link...' : 'Send reset link'}
                            </Button>
                        </form>

                        <p className="mt-6 text-center text-sm text-muted-foreground">
                            Remember your password?{' '}
                            <Link href={route('login')} className="font-medium text-primary hover:underline">
                                Sign in
                            </Link>
                        </p>
                    </CardContent>
                </Card>
            </div>
        </div>
    );
}
