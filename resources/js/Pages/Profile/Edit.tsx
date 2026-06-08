import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, useForm, usePage } from '@inertiajs/react';
import { Button } from '@/Components/ui/button';
import { Input } from '@/Components/ui/input';
import { Label } from '@/Components/ui/label';
import { Textarea } from '@/Components/ui/textarea';
import { Card, CardContent, CardHeader, CardTitle } from '@/Components/ui/card';
import InputError from '@/Components/InputError';
import { Transition } from '@headlessui/react';
import { FormEventHandler } from 'react';
import { PageProps } from '@/types';

export default function Edit() {
    const user = usePage<PageProps>().props.auth.user;

    const { data, setData, patch, errors, processing, recentlySuccessful } = useForm({
        name: user.name,
        email: user.email,
        phone: user.phone || '',
        location: user.location || '',
        title: user.title || '',
        summary: user.summary || '',
        website: user.website || '',
        linkedin_url: user.linkedin_url || '',
        github_url: user.github_url || '',
    });

    const submit: FormEventHandler = (e) => {
        e.preventDefault();
        patch(route('profile.update'));
    };

    return (
        <AuthenticatedLayout
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    Profile
                </h2>
            }
        >
            <Head title="Profile" />

            <div className="py-12">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <Card>
                        <CardHeader>
                            <CardTitle>Personal Information</CardTitle>
                        </CardHeader>
                        <CardContent>
                            <form onSubmit={submit} className="space-y-6">
                                <div className="grid gap-4 md:grid-cols-2">
                                    <div className="space-y-2">
                                        <Label htmlFor="name">Full Name</Label>
                                        <Input id="name" value={data.name} onChange={(e) => setData('name', e.target.value)} required />
                                        <InputError message={errors.name} />
                                    </div>
                                    <div className="space-y-2">
                                        <Label htmlFor="email">Email</Label>
                                        <Input id="email" type="email" value={data.email} onChange={(e) => setData('email', e.target.value)} required />
                                        <InputError message={errors.email} />
                                    </div>
                                    <div className="space-y-2">
                                        <Label htmlFor="phone">Phone</Label>
                                        <Input id="phone" value={data.phone} onChange={(e) => setData('phone', e.target.value)} />
                                        <InputError message={errors.phone} />
                                    </div>
                                    <div className="space-y-2">
                                        <Label htmlFor="location">Location</Label>
                                        <Input id="location" value={data.location} onChange={(e) => setData('location', e.target.value)} />
                                        <InputError message={errors.location} />
                                    </div>
                                    <div className="space-y-2">
                                        <Label htmlFor="title">Professional Title</Label>
                                        <Input id="title" value={data.title} onChange={(e) => setData('title', e.target.value)} placeholder="e.g. Senior Full-Stack Engineer" />
                                        <InputError message={errors.title} />
                                    </div>
                                    <div className="space-y-2">
                                        <Label htmlFor="website">Website</Label>
                                        <Input id="website" value={data.website} onChange={(e) => setData('website', e.target.value)} placeholder="https://yoursite.com" />
                                        <InputError message={errors.website} />
                                    </div>
                                    <div className="space-y-2">
                                        <Label htmlFor="linkedin_url">LinkedIn URL</Label>
                                        <Input id="linkedin_url" value={data.linkedin_url} onChange={(e) => setData('linkedin_url', e.target.value)} />
                                        <InputError message={errors.linkedin_url} />
                                    </div>
                                    <div className="space-y-2">
                                        <Label htmlFor="github_url">GitHub URL</Label>
                                        <Input id="github_url" value={data.github_url} onChange={(e) => setData('github_url', e.target.value)} />
                                        <InputError message={errors.github_url} />
                                    </div>
                                </div>
                                <div className="space-y-2">
                                    <Label htmlFor="summary">Professional Summary</Label>
                                    <Textarea id="summary" value={data.summary} onChange={(e) => setData('summary', e.target.value)} rows={4} />
                                    <InputError message={errors.summary} />
                                </div>

                                <div className="flex items-center gap-4">
                                    <Button disabled={processing}>Save</Button>
                                    <Transition show={recentlySuccessful} enter="transition ease-in-out" enterFrom="opacity-0" leave="transition ease-in-out" leaveTo="opacity-0">
                                        <p className="text-sm text-green-600">Saved.</p>
                                    </Transition>
                                </div>
                            </form>
                        </CardContent>
                    </Card>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
