import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, router, useForm, usePage } from '@inertiajs/react';
import { Button } from '@/Components/ui/button';
import { Input } from '@/Components/ui/input';
import { Label } from '@/Components/ui/label';
import { Textarea } from '@/Components/ui/textarea';
import { Card, CardContent } from '@/Components/ui/card';
import { Badge } from '@/Components/ui/badge';
import {
  Dialog, DialogContent, DialogHeader, DialogTitle,
} from '@/Components/ui/dialog';
import {
  Accordion, AccordionContent, AccordionItem, AccordionTrigger,
} from '@/Components/ui/accordion';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/Components/ui/select';
import InputError from '@/Components/InputError';
import { Transition } from '@headlessui/react';
import { PageProps, WorkExperience, Education, Skill, Certification, Project } from '@/types';
import { FormEventHandler, useState } from 'react';
import { Pencil, Plus, Trash2, ExternalLink } from 'lucide-react';

interface Props extends PageProps {
  experiences: WorkExperience[];
  education: Education[];
  skills: Skill[];
  certifications: Certification[];
  projects: Project[];
}

export default function Manage({ experiences, education, skills, certifications, projects }: Props) {
  const user = usePage<PageProps>().props.auth.user;

  // Personal info form
  const profileForm = useForm({
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

  const submitProfile: FormEventHandler = (e) => {
    e.preventDefault();
    profileForm.patch(route('profile.update'));
  };

  // Work Experience
  const [expDialog, setExpDialog] = useState(false);
  const [editingExp, setEditingExp] = useState<WorkExperience | null>(null);
  const expForm = useForm({ company: '', position: '', location: '', start_date: '', end_date: '', is_current: false, description: '' });

  const openCreateExp = () => { expForm.reset(); setEditingExp(null); setExpDialog(true); };
  const openEditExp = (item: WorkExperience) => {
    setEditingExp(item);
    expForm.setData({ company: item.company, position: item.position, location: item.location || '', start_date: item.start_date, end_date: item.end_date || '', is_current: item.is_current, description: item.description || '' });
    setExpDialog(true);
  };
  const submitExp: FormEventHandler = (e) => {
    e.preventDefault();
    if (editingExp) {
      expForm.put(route('experience.update', editingExp.id), { onSuccess: () => { setExpDialog(false); expForm.reset(); setEditingExp(null); } });
    } else {
      expForm.post(route('experience.store'), { onSuccess: () => { setExpDialog(false); expForm.reset(); } });
    }
  };
  const destroyExp = (id: number) => { if (confirm('Delete this experience?')) router.delete(route('experience.destroy', id)); };

  // Education
  const [eduDialog, setEduDialog] = useState(false);
  const [editingEdu, setEditingEdu] = useState<Education | null>(null);
  const eduForm = useForm({ institution: '', degree: '', field_of_study: '', start_date: '', end_date: '', gpa: '' as string | number });

  const openCreateEdu = () => { eduForm.reset(); setEditingEdu(null); setEduDialog(true); };
  const openEditEdu = (item: Education) => {
    setEditingEdu(item);
    eduForm.setData({ institution: item.institution, degree: item.degree, field_of_study: item.field_of_study || '', start_date: item.start_date, end_date: item.end_date || '', gpa: item.gpa?.toString() || '' });
    setEduDialog(true);
  };
  const submitEdu: FormEventHandler = (e) => {
    e.preventDefault();
    if (editingEdu) {
      eduForm.put(route('education.update', editingEdu.id), { onSuccess: () => { setEduDialog(false); eduForm.reset(); setEditingEdu(null); } });
    } else {
      eduForm.post(route('education.store'), { onSuccess: () => { setEduDialog(false); eduForm.reset(); } });
    }
  };
  const destroyEdu = (id: number) => { if (confirm('Delete this education?')) router.delete(route('education.destroy', id)); };

  // Skills
  const [skillDialog, setSkillDialog] = useState(false);
  const skillForm = useForm({ name: '', category: 'Technical', proficiency_level: 'intermediate' });
  const skillCategories = ['Technical', 'Design', 'Soft', 'Language', 'Tool'];
  const skillLevels = ['beginner', 'intermediate', 'advanced', 'expert'];

  const groupedSkills = skills.reduce<Record<string, Skill[]>>((acc, s) => {
    (acc[s.category] = acc[s.category] || []).push(s);
    return acc;
  }, {});

  const submitSkill: FormEventHandler = (e) => {
    e.preventDefault();
    skillForm.post(route('skills.store'), { onSuccess: () => { setSkillDialog(false); skillForm.reset(); } });
  };
  const destroySkill = (id: number) => { if (confirm('Delete this skill?')) router.delete(route('skills.destroy', id)); };

  const levelColor = (lvl: string) => {
    switch (lvl) {
      case 'expert': return 'default';
      case 'advanced': return 'secondary';
      case 'intermediate': return 'outline';
      default: return 'outline';
    }
  };

  // Certifications
  const [certDialog, setCertDialog] = useState(false);
  const [editingCert, setEditingCert] = useState<Certification | null>(null);
  const certForm = useForm({ name: '', issuing_organization: '', issue_date: '', expiration_date: '', credential_url: '' });

  const openCreateCert = () => { certForm.reset(); setEditingCert(null); setCertDialog(true); };
  const openEditCert = (item: Certification) => {
    setEditingCert(item);
    certForm.setData({ name: item.name, issuing_organization: item.issuing_organization, issue_date: item.issue_date, expiration_date: item.expiration_date || '', credential_url: item.credential_url || '' });
    setCertDialog(true);
  };
  const submitCert: FormEventHandler = (e) => {
    e.preventDefault();
    if (editingCert) {
      certForm.put(route('certifications.update', editingCert.id), { onSuccess: () => { setCertDialog(false); certForm.reset(); setEditingCert(null); } });
    } else {
      certForm.post(route('certifications.store'), { onSuccess: () => { setCertDialog(false); certForm.reset(); } });
    }
  };
  const destroyCert = (id: number) => { if (confirm('Delete this certification?')) router.delete(route('certifications.destroy', id)); };

  // Projects
  const [projDialog, setProjDialog] = useState(false);
  const [editingProj, setEditingProj] = useState<Project | null>(null);
  const projForm = useForm({ name: '', description: '', technologies_used: [] as string[], url: '', start_date: '', end_date: '' });
  const [techInput, setTechInput] = useState('');

  const addTech = () => {
    if (techInput.trim() && !projForm.data.technologies_used.includes(techInput.trim())) {
      projForm.setData('technologies_used', [...projForm.data.technologies_used, techInput.trim()]);
    }
    setTechInput('');
  };

  const openCreateProj = () => { projForm.reset(); setEditingProj(null); setProjDialog(true); };
  const openEditProj = (item: Project) => {
    setEditingProj(item);
    projForm.setData({ name: item.name, description: item.description || '', technologies_used: item.technologies_used || [], url: item.url || '', start_date: item.start_date || '', end_date: item.end_date || '' });
    setProjDialog(true);
  };
  const submitProj: FormEventHandler = (e) => {
    e.preventDefault();
    if (editingProj) {
      projForm.put(route('projects.update', editingProj.id), { onSuccess: () => { setProjDialog(false); projForm.reset(); setEditingProj(null); } });
    } else {
      projForm.post(route('projects.store'), { onSuccess: () => { setProjDialog(false); projForm.reset(); } });
    }
  };
  const destroyProj = (id: number) => { if (confirm('Delete this project?')) router.delete(route('projects.destroy', id)); };

  return (
    <AuthenticatedLayout header={<h2 className="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">Profile</h2>}>
      <Head title="Profile" />

      <div className="py-12">
        <div className="mx-auto max-w-4xl sm:px-6 lg:px-8">
          <div className="space-y-6">
            {/* Personal Information */}
            <Card>
              <CardContent className="pt-6">
                <form onSubmit={submitProfile} className="space-y-6">
                  <div className="grid gap-4 md:grid-cols-2">
                    <div className="space-y-2">
                      <Label htmlFor="name">Full Name</Label>
                      <Input id="name" value={profileForm.data.name} onChange={(e) => profileForm.setData('name', e.target.value)} required />
                      <InputError message={profileForm.errors.name} />
                    </div>
                    <div className="space-y-2">
                      <Label htmlFor="email">Email</Label>
                      <Input id="email" type="email" value={profileForm.data.email} onChange={(e) => profileForm.setData('email', e.target.value)} required />
                      <InputError message={profileForm.errors.email} />
                    </div>
                    <div className="space-y-2">
                      <Label htmlFor="phone">Phone</Label>
                      <Input id="phone" value={profileForm.data.phone} onChange={(e) => profileForm.setData('phone', e.target.value)} />
                      <InputError message={profileForm.errors.phone} />
                    </div>
                    <div className="space-y-2">
                      <Label htmlFor="location">Location</Label>
                      <Input id="location" value={profileForm.data.location} onChange={(e) => profileForm.setData('location', e.target.value)} />
                      <InputError message={profileForm.errors.location} />
                    </div>
                    <div className="space-y-2">
                      <Label htmlFor="title">Professional Title</Label>
                      <Input id="title" value={profileForm.data.title} onChange={(e) => profileForm.setData('title', e.target.value)} placeholder="e.g. Senior Full-Stack Engineer" />
                      <InputError message={profileForm.errors.title} />
                    </div>
                    <div className="space-y-2">
                      <Label htmlFor="website">Website</Label>
                      <Input id="website" value={profileForm.data.website} onChange={(e) => profileForm.setData('website', e.target.value)} placeholder="https://yoursite.com" />
                      <InputError message={profileForm.errors.website} />
                    </div>
                    <div className="space-y-2">
                      <Label htmlFor="linkedin_url">LinkedIn URL</Label>
                      <Input id="linkedin_url" value={profileForm.data.linkedin_url} onChange={(e) => profileForm.setData('linkedin_url', e.target.value)} />
                      <InputError message={profileForm.errors.linkedin_url} />
                    </div>
                    <div className="space-y-2">
                      <Label htmlFor="github_url">GitHub URL</Label>
                      <Input id="github_url" value={profileForm.data.github_url} onChange={(e) => profileForm.setData('github_url', e.target.value)} />
                      <InputError message={profileForm.errors.github_url} />
                    </div>
                  </div>
                  <div className="space-y-2">
                    <Label htmlFor="summary">Professional Summary</Label>
                    <Textarea id="summary" value={profileForm.data.summary} onChange={(e) => profileForm.setData('summary', e.target.value)} rows={4} />
                    <InputError message={profileForm.errors.summary} />
                  </div>
                  <div className="flex items-center gap-4">
                    <Button disabled={profileForm.processing}>Save</Button>
                    <Transition show={profileForm.recentlySuccessful} enter="transition ease-in-out" enterFrom="opacity-0" leave="transition ease-in-out" leaveTo="opacity-0">
                      <p className="text-sm text-green-600">Saved.</p>
                    </Transition>
                  </div>
                </form>
              </CardContent>
            </Card>

            {/* Collapsible Sections */}
            <Accordion type="single" collapsible className="space-y-2">
              {/* Work Experience */}
              <AccordionItem value="experience" className="rounded-lg border bg-card text-card-foreground shadow-sm">
                <AccordionTrigger className="px-6">
                  <span className="flex items-center gap-2">
                    Work Experience
                    <Badge variant="secondary" className="ml-2">{experiences.length}</Badge>
                  </span>
                </AccordionTrigger>
                <AccordionContent className="px-6">
                  <div className="mb-4 flex justify-end">
                    <Dialog open={expDialog} onOpenChange={setExpDialog}>
                      <Button size="sm" onClick={openCreateExp}><Plus className="mr-1 h-4 w-4" />Add</Button>
                      <DialogContent className="sm:max-w-xl">
                        <DialogHeader><DialogTitle>{editingExp ? 'Edit Experience' : 'Add Experience'}</DialogTitle></DialogHeader>
                        <form onSubmit={submitExp} className="space-y-4">
                          <div className="grid gap-4 md:grid-cols-2">
                            <div className="space-y-2"><Label>Company</Label><Input value={expForm.data.company} onChange={(e) => expForm.setData('company', e.target.value)} required /><InputError message={expForm.errors.company} /></div>
                            <div className="space-y-2"><Label>Position</Label><Input value={expForm.data.position} onChange={(e) => expForm.setData('position', e.target.value)} required /><InputError message={expForm.errors.position} /></div>
                            <div className="space-y-2"><Label>Location</Label><Input value={expForm.data.location} onChange={(e) => expForm.setData('location', e.target.value)} /><InputError message={expForm.errors.location} /></div>
                            <div className="space-y-2"><Label>Start Date</Label><Input type="date" value={expForm.data.start_date} onChange={(e) => expForm.setData('start_date', e.target.value)} required /><InputError message={expForm.errors.start_date} /></div>
                            <div className="space-y-2"><Label>End Date</Label><Input type="date" value={expForm.data.end_date} onChange={(e) => expForm.setData('end_date', e.target.value)} disabled={expForm.data.is_current} /><InputError message={expForm.errors.end_date} /></div>
                            <div className="flex items-center space-x-2 pt-8">
                              <input type="checkbox" id="is_current" checked={expForm.data.is_current} onChange={(e) => expForm.setData('is_current', e.target.checked)} className="rounded border-gray-300" />
                              <Label htmlFor="is_current">I currently work here</Label>
                            </div>
                          </div>
                          <div className="space-y-2"><Label>Description</Label><Textarea value={expForm.data.description} onChange={(e) => expForm.setData('description', e.target.value)} rows={4} placeholder="Describe your role and achievements..." /><InputError message={expForm.errors.description} /></div>
                          <div className="flex justify-end gap-2">
                            <Button type="button" variant="outline" onClick={() => { setExpDialog(false); expForm.reset(); setEditingExp(null); }}>Cancel</Button>
                            <Button disabled={expForm.processing}>{editingExp ? 'Update' : 'Save'}</Button>
                          </div>
                        </form>
                      </DialogContent>
                    </Dialog>
                  </div>
                  {experiences.length === 0 ? (
                    <p className="py-4 text-center text-muted-foreground">No work experience yet.</p>
                  ) : (
                    <div className="space-y-3">
                      {experiences.map((item) => (
                        <Card key={item.id}>
                          <CardContent className="flex items-start justify-between py-3">
                            <div className="flex-1">
                              <div className="flex items-center gap-2">
                                <h3 className="font-semibold text-sm">{item.position}</h3>
                                {item.is_current && <Badge variant="default" className="text-xs">Current</Badge>}
                              </div>
                              <p className="text-xs text-muted-foreground">{item.company}{item.location ? `, ${item.location}` : ''}</p>
                              <p className="text-xs text-muted-foreground">
                                {new Date(item.start_date).toLocaleDateString('en-US', { month: 'short', year: 'numeric' })} –{item.is_current ? ' Present' : new Date(item.end_date!).toLocaleDateString('en-US', { month: 'short', year: 'numeric' })}
                              </p>
                              {item.description && <p className="mt-1 text-xs whitespace-pre-line line-clamp-2">{item.description}</p>}
                            </div>
                            <div className="flex items-center gap-1 ml-4">
                              <Button variant="ghost" size="icon" onClick={() => openEditExp(item)}><Pencil className="h-3.5 w-3.5" /></Button>
                              <Button variant="ghost" size="icon" onClick={() => destroyExp(item.id)}><Trash2 className="h-3.5 w-3.5 text-destructive" /></Button>
                            </div>
                          </CardContent>
                        </Card>
                      ))}
                    </div>
                  )}
                </AccordionContent>
              </AccordionItem>

              {/* Education */}
              <AccordionItem value="education" className="rounded-lg border bg-card text-card-foreground shadow-sm">
                <AccordionTrigger className="px-6">
                  <span className="flex items-center gap-2">
                    Education
                    <Badge variant="secondary" className="ml-2">{education.length}</Badge>
                  </span>
                </AccordionTrigger>
                <AccordionContent className="px-6">
                  <div className="mb-4 flex justify-end">
                    <Dialog open={eduDialog} onOpenChange={setEduDialog}>
                      <Button size="sm" onClick={openCreateEdu}><Plus className="mr-1 h-4 w-4" />Add</Button>
                      <DialogContent className="sm:max-w-xl">
                        <DialogHeader><DialogTitle>{editingEdu ? 'Edit Education' : 'Add Education'}</DialogTitle></DialogHeader>
                        <form onSubmit={submitEdu} className="space-y-4">
                          <div className="grid gap-4 md:grid-cols-2">
                            <div className="space-y-2"><Label>Institution</Label><Input value={eduForm.data.institution} onChange={(e) => eduForm.setData('institution', e.target.value)} required /><InputError message={eduForm.errors.institution} /></div>
                            <div className="space-y-2"><Label>Degree</Label><Input value={eduForm.data.degree} onChange={(e) => eduForm.setData('degree', e.target.value)} required /><InputError message={eduForm.errors.degree} /></div>
                            <div className="space-y-2"><Label>Field of Study</Label><Input value={eduForm.data.field_of_study} onChange={(e) => eduForm.setData('field_of_study', e.target.value)} /><InputError message={eduForm.errors.field_of_study} /></div>
                            <div className="space-y-2"><Label>GPA</Label><Input type="number" step="0.01" min="0" max="4" value={eduForm.data.gpa} onChange={(e) => eduForm.setData('gpa', e.target.value)} /><InputError message={eduForm.errors.gpa} /></div>
                            <div className="space-y-2"><Label>Start Date</Label><Input type="date" value={eduForm.data.start_date} onChange={(e) => eduForm.setData('start_date', e.target.value)} required /><InputError message={eduForm.errors.start_date} /></div>
                            <div className="space-y-2"><Label>End Date</Label><Input type="date" value={eduForm.data.end_date} onChange={(e) => eduForm.setData('end_date', e.target.value)} /><InputError message={eduForm.errors.end_date} /></div>
                          </div>
                          <div className="flex justify-end gap-2">
                            <Button type="button" variant="outline" onClick={() => { setEduDialog(false); eduForm.reset(); setEditingEdu(null); }}>Cancel</Button>
                            <Button disabled={eduForm.processing}>{editingEdu ? 'Update' : 'Save'}</Button>
                          </div>
                        </form>
                      </DialogContent>
                    </Dialog>
                  </div>
                  {education.length === 0 ? (
                    <p className="py-4 text-center text-muted-foreground">No education yet.</p>
                  ) : (
                    <div className="space-y-3">
                      {education.map((item) => (
                        <Card key={item.id}>
                          <CardContent className="flex items-start justify-between py-3">
                            <div>
                              <h3 className="text-sm font-semibold">{item.degree}{item.field_of_study ? ` in ${item.field_of_study}` : ''}</h3>
                              <p className="text-xs text-muted-foreground">{item.institution}</p>
                              <p className="text-xs text-muted-foreground">
                                {new Date(item.start_date).getFullYear()} – {item.end_date ? new Date(item.end_date).getFullYear() : 'Present'}
                                {item.gpa ? ` | GPA: ${item.gpa}` : ''}
                              </p>
                            </div>
                            <div className="flex items-center gap-1 ml-4">
                              <Button variant="ghost" size="icon" onClick={() => openEditEdu(item)}><Pencil className="h-3.5 w-3.5" /></Button>
                              <Button variant="ghost" size="icon" onClick={() => destroyEdu(item.id)}><Trash2 className="h-3.5 w-3.5 text-destructive" /></Button>
                            </div>
                          </CardContent>
                        </Card>
                      ))}
                    </div>
                  )}
                </AccordionContent>
              </AccordionItem>

              {/* Skills */}
              <AccordionItem value="skills" className="rounded-lg border bg-card text-card-foreground shadow-sm">
                <AccordionTrigger className="px-6">
                  <span className="flex items-center gap-2">
                    Skills
                    <Badge variant="secondary" className="ml-2">{skills.length}</Badge>
                  </span>
                </AccordionTrigger>
                <AccordionContent className="px-6">
                  <div className="mb-4 flex justify-end">
                    <Dialog open={skillDialog} onOpenChange={setSkillDialog}>
                      <Button size="sm" onClick={() => { skillForm.reset(); setSkillDialog(true); }}><Plus className="mr-1 h-4 w-4" />Add</Button>
                      <DialogContent>
                        <DialogHeader><DialogTitle>Add Skill</DialogTitle></DialogHeader>
                        <form onSubmit={submitSkill} className="space-y-4">
                          <div className="space-y-2"><Label>Skill Name</Label><Input value={skillForm.data.name} onChange={(e) => skillForm.setData('name', e.target.value)} required /><InputError message={skillForm.errors.name} /></div>
                          <div className="space-y-2">
                            <Label>Category</Label>
                            <Select value={skillForm.data.category} onValueChange={(v) => skillForm.setData('category', v)}>
                              <SelectTrigger><SelectValue /></SelectTrigger>
                              <SelectContent>{skillCategories.map((c) => <SelectItem key={c} value={c}>{c}</SelectItem>)}</SelectContent>
                            </Select>
                            <InputError message={skillForm.errors.category} />
                          </div>
                          <div className="space-y-2">
                            <Label>Proficiency</Label>
                            <Select value={skillForm.data.proficiency_level} onValueChange={(v) => skillForm.setData('proficiency_level', v)}>
                              <SelectTrigger><SelectValue /></SelectTrigger>
                              <SelectContent>{skillLevels.map((l) => <SelectItem key={l} value={l}>{l.charAt(0).toUpperCase() + l.slice(1)}</SelectItem>)}</SelectContent>
                            </Select>
                            <InputError message={skillForm.errors.proficiency_level} />
                          </div>
                          <div className="flex justify-end gap-2">
                            <Button type="button" variant="outline" onClick={() => { setSkillDialog(false); skillForm.reset(); }}>Cancel</Button>
                            <Button disabled={skillForm.processing}>Save</Button>
                          </div>
                        </form>
                      </DialogContent>
                    </Dialog>
                  </div>
                  {Object.keys(groupedSkills).length === 0 ? (
                    <p className="py-4 text-center text-muted-foreground">No skills yet.</p>
                  ) : (
                    <div className="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                      {Object.entries(groupedSkills).map(([category, catSkills]) => (
                        <Card key={category}>
                          <CardContent className="pt-4">
                            <h4 className="mb-2 text-sm font-semibold">{category}</h4>
                            <div className="flex flex-wrap gap-1.5">
                              {catSkills.map((s) => (
                                <div key={s.id} className="group relative">
                                  <Badge variant={levelColor(s.proficiency_level) as any} className="pr-6 text-xs">
                                    {s.name}
                                    <button onClick={() => destroySkill(s.id)} className="ml-1 hover:text-destructive">
                                      <Trash2 className="h-3 w-3" />
                                    </button>
                                  </Badge>
                                </div>
                              ))}
                            </div>
                          </CardContent>
                        </Card>
                      ))}
                    </div>
                  )}
                </AccordionContent>
              </AccordionItem>

              {/* Certifications */}
              <AccordionItem value="certifications" className="rounded-lg border bg-card text-card-foreground shadow-sm">
                <AccordionTrigger className="px-6">
                  <span className="flex items-center gap-2">
                    Certifications
                    <Badge variant="secondary" className="ml-2">{certifications.length}</Badge>
                  </span>
                </AccordionTrigger>
                <AccordionContent className="px-6">
                  <div className="mb-4 flex justify-end">
                    <Dialog open={certDialog} onOpenChange={setCertDialog}>
                      <Button size="sm" onClick={openCreateCert}><Plus className="mr-1 h-4 w-4" />Add</Button>
                      <DialogContent className="sm:max-w-xl">
                        <DialogHeader><DialogTitle>{editingCert ? 'Edit Certification' : 'Add Certification'}</DialogTitle></DialogHeader>
                        <form onSubmit={submitCert} className="space-y-4">
                          <div className="grid gap-4 md:grid-cols-2">
                            <div className="space-y-2"><Label>Name</Label><Input value={certForm.data.name} onChange={(e) => certForm.setData('name', e.target.value)} required /><InputError message={certForm.errors.name} /></div>
                            <div className="space-y-2"><Label>Issuing Organization</Label><Input value={certForm.data.issuing_organization} onChange={(e) => certForm.setData('issuing_organization', e.target.value)} required /><InputError message={certForm.errors.issuing_organization} /></div>
                            <div className="space-y-2"><Label>Issue Date</Label><Input type="date" value={certForm.data.issue_date} onChange={(e) => certForm.setData('issue_date', e.target.value)} required /><InputError message={certForm.errors.issue_date} /></div>
                            <div className="space-y-2"><Label>Expiration Date</Label><Input type="date" value={certForm.data.expiration_date} onChange={(e) => certForm.setData('expiration_date', e.target.value)} /><InputError message={certForm.errors.expiration_date} /></div>
                            <div className="space-y-2 md:col-span-2"><Label>Credential URL</Label><Input value={certForm.data.credential_url} onChange={(e) => certForm.setData('credential_url', e.target.value)} /><InputError message={certForm.errors.credential_url} /></div>
                          </div>
                          <div className="flex justify-end gap-2">
                            <Button type="button" variant="outline" onClick={() => { setCertDialog(false); certForm.reset(); setEditingCert(null); }}>Cancel</Button>
                            <Button disabled={certForm.processing}>{editingCert ? 'Update' : 'Save'}</Button>
                          </div>
                        </form>
                      </DialogContent>
                    </Dialog>
                  </div>
                  {certifications.length === 0 ? (
                    <p className="py-4 text-center text-muted-foreground">No certifications yet.</p>
                  ) : (
                    <div className="grid gap-3 md:grid-cols-2 lg:grid-cols-3">
                      {certifications.map((item) => (
                        <Card key={item.id}>
                          <CardContent className="py-3">
                            <div className="flex items-start justify-between">
                              <div className="flex-1 min-w-0">
                                <h3 className="text-sm font-semibold truncate">{item.name}</h3>
                                <p className="text-xs text-muted-foreground">{item.issuing_organization}</p>
                                <p className="text-xs text-muted-foreground">
                                  Issued: {new Date(item.issue_date).toLocaleDateString('en-US', { month: 'short', year: 'numeric' })}
                                  {item.expiration_date && ` · Expires: ${new Date(item.expiration_date).toLocaleDateString('en-US', { month: 'short', year: 'numeric' })}`}
                                </p>
                                {item.credential_url && (
                                  <a href={item.credential_url} target="_blank" className="mt-1 inline-flex items-center text-xs text-primary hover:underline">
                                    View credential <ExternalLink className="ml-1 h-3 w-3" />
                                  </a>
                                )}
                              </div>
                              <div className="flex items-center gap-1 ml-2 shrink-0">
                                <Button variant="ghost" size="icon" onClick={() => openEditCert(item)}><Pencil className="h-3.5 w-3.5" /></Button>
                                <Button variant="ghost" size="icon" onClick={() => destroyCert(item.id)}><Trash2 className="h-3.5 w-3.5 text-destructive" /></Button>
                              </div>
                            </div>
                          </CardContent>
                        </Card>
                      ))}
                    </div>
                  )}
                </AccordionContent>
              </AccordionItem>

              {/* Projects */}
              <AccordionItem value="projects" className="rounded-lg border bg-card text-card-foreground shadow-sm">
                <AccordionTrigger className="px-6">
                  <span className="flex items-center gap-2">
                    Projects
                    <Badge variant="secondary" className="ml-2">{projects.length}</Badge>
                  </span>
                </AccordionTrigger>
                <AccordionContent className="px-6">
                  <div className="mb-4 flex justify-end">
                    <Dialog open={projDialog} onOpenChange={setProjDialog}>
                      <Button size="sm" onClick={openCreateProj}><Plus className="mr-1 h-4 w-4" />Add</Button>
                      <DialogContent className="sm:max-w-xl">
                        <DialogHeader><DialogTitle>{editingProj ? 'Edit Project' : 'Add Project'}</DialogTitle></DialogHeader>
                        <form onSubmit={submitProj} className="space-y-4">
                          <div className="grid gap-4 md:grid-cols-2">
                            <div className="space-y-2 md:col-span-2"><Label>Project Name</Label><Input value={projForm.data.name} onChange={(e) => projForm.setData('name', e.target.value)} required /><InputError message={projForm.errors.name} /></div>
                            <div className="space-y-2 md:col-span-2"><Label>Description</Label><Textarea value={projForm.data.description} onChange={(e) => projForm.setData('description', e.target.value)} rows={3} /><InputError message={projForm.errors.description} /></div>
                            <div className="space-y-2 md:col-span-2">
                              <Label>Technologies Used</Label>
                              <div className="flex gap-2">
                                <Input value={techInput} onChange={(e) => setTechInput(e.target.value)} onKeyDown={(e) => e.key === 'Enter' && (e.preventDefault(), addTech())} placeholder="Type and press Enter" />
                                <Button type="button" variant="outline" onClick={addTech}>Add</Button>
                              </div>
                              <div className="flex flex-wrap gap-1 mt-1">
                                {projForm.data.technologies_used.map((tech) => (
                                  <Badge key={tech} variant="secondary" className="cursor-pointer text-xs" onClick={() => projForm.setData('technologies_used', projForm.data.technologies_used.filter((t) => t !== tech))}>
                                    {tech} &times;
                                  </Badge>
                                ))}
                              </div>
                            </div>
                            <div className="space-y-2"><Label>URL</Label><Input value={projForm.data.url} onChange={(e) => projForm.setData('url', e.target.value)} /><InputError message={projForm.errors.url} /></div>
                            <div className="space-y-2"><Label>Start Date</Label><Input type="date" value={projForm.data.start_date} onChange={(e) => projForm.setData('start_date', e.target.value)} /><InputError message={projForm.errors.start_date} /></div>
                          </div>
                          <div className="flex justify-end gap-2">
                            <Button type="button" variant="outline" onClick={() => { setProjDialog(false); projForm.reset(); setEditingProj(null); }}>Cancel</Button>
                            <Button disabled={projForm.processing}>{editingProj ? 'Update' : 'Save'}</Button>
                          </div>
                        </form>
                      </DialogContent>
                    </Dialog>
                  </div>
                  {projects.length === 0 ? (
                    <p className="py-4 text-center text-muted-foreground">No projects yet.</p>
                  ) : (
                    <div className="grid gap-3 md:grid-cols-2">
                      {projects.map((item) => (
                        <Card key={item.id}>
                          <CardContent className="py-3">
                            <div className="flex items-start justify-between">
                              <div className="flex-1 min-w-0">
                                <h3 className="text-sm font-semibold truncate">{item.name}</h3>
                                {item.description && <p className="mt-1 text-xs text-muted-foreground line-clamp-2">{item.description}</p>}
                                {item.technologies_used && item.technologies_used.length > 0 && (
                                  <div className="mt-2 flex flex-wrap gap-1">
                                    {item.technologies_used.map((tech) => <Badge key={tech} variant="outline" className="text-xs">{tech}</Badge>)}
                                  </div>
                                )}
                                {item.url && (
                                  <a href={item.url} target="_blank" className="mt-1 inline-flex items-center text-xs text-primary hover:underline">
                                    View project <ExternalLink className="ml-1 h-3 w-3" />
                                  </a>
                                )}
                              </div>
                              <div className="flex items-center gap-1 ml-2 shrink-0">
                                <Button variant="ghost" size="icon" onClick={() => openEditProj(item)}><Pencil className="h-3.5 w-3.5" /></Button>
                                <Button variant="ghost" size="icon" onClick={() => destroyProj(item.id)}><Trash2 className="h-3.5 w-3.5 text-destructive" /></Button>
                              </div>
                            </div>
                          </CardContent>
                        </Card>
                      ))}
                    </div>
                  )}
                </AccordionContent>
              </AccordionItem>
            </Accordion>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  );
}
