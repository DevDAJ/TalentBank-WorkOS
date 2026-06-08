export const cvTemplates = [
    { id: 'classic', name: 'Classic', description: 'Traditional serif layout, ideal for conservative industries', font: 'Times New Roman' },
    { id: 'modern', name: 'Modern', description: 'Clean sans-serif with blue accent, perfect for tech', font: 'Helvetica / Arial' },
    { id: 'minimal', name: 'Minimal', description: 'Ultra-clean with lots of whitespace, design-forward', font: 'Calibri' },
] as const;

export type CvTemplateId = (typeof cvTemplates)[number]['id'];

export const cvTemplateStyles: Record<CvTemplateId, {
    wrapper: string;
    name: string;
    divider: string;
    heading: string;
    accent: string;
    date: string;
    body: string;
    muted: string;
    summaryLabel: string;
}> = {
    classic: {
        wrapper: 'font-serif text-gray-900',
        name: 'text-lg uppercase tracking-widest text-gray-900',
        divider: 'border-black',
        heading: 'text-xs font-bold uppercase tracking-widest text-gray-900 border-b border-black pb-1',
        accent: 'text-gray-800',
        date: 'text-xs text-gray-600 italic',
        body: 'text-sm text-gray-800',
        muted: 'text-xs text-gray-700',
        summaryLabel: 'Professional Summary',
    },
    modern: {
        wrapper: 'font-sans text-gray-900',
        name: 'text-xl font-bold text-primary',
        divider: 'border-primary',
        heading: 'text-sm font-semibold uppercase tracking-wider text-primary border-b border-primary pb-1',
        accent: 'text-primary',
        date: 'text-xs text-gray-500',
        body: 'text-sm text-gray-700',
        muted: 'text-xs text-gray-600',
        summaryLabel: 'Professional Summary',
    },
    minimal: {
        wrapper: 'font-[Calibri,sans-serif] text-gray-900',
        name: 'text-2xl font-light tracking-tight uppercase text-gray-900',
        divider: 'border-gray-300',
        heading: 'text-xs font-semibold uppercase tracking-[0.2em] text-gray-800 border-b border-gray-300 pb-1',
        accent: 'text-gray-800',
        date: 'text-xs text-gray-600',
        body: 'text-sm text-gray-700',
        muted: 'text-xs text-gray-600',
        summaryLabel: 'About',
    },
};
