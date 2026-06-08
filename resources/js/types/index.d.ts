export interface User {
    id: number;
    name: string;
    email: string;
    email_verified_at?: string;
    phone?: string;
    location?: string;
    title?: string;
    summary?: string;
    website?: string;
    linkedin_url?: string;
    github_url?: string;
}

export type PageProps<
    T extends Record<string, unknown> = Record<string, unknown>,
> = T & {
    auth: {
        user: User;
    };
    flash?: {
        success?: string;
        error?: string;
    };
};

export interface WorkExperience {
    id: number;
    user_id: number;
    company: string;
    position: string;
    location: string | null;
    start_date: string;
    end_date: string | null;
    is_current: boolean;
    description: string | null;
}

export interface Education {
    id: number;
    user_id: number;
    institution: string;
    degree: string;
    field_of_study: string | null;
    start_date: string;
    end_date: string | null;
    gpa: number | null;
}

export interface Skill {
    id: number;
    user_id: number;
    name: string;
    category: string;
    proficiency_level: string;
}

export interface Certification {
    id: number;
    user_id: number;
    name: string;
    issuing_organization: string;
    issue_date: string;
    expiration_date: string | null;
    credential_url: string | null;
}

export interface Project {
    id: number;
    user_id: number;
    name: string;
    description: string | null;
    technologies_used: string[] | null;
    url: string | null;
    start_date: string | null;
    end_date: string | null;
}

export interface CareerSuggestion {
    id: number;
    suggested_role: string;
    description: string;
    match_score: number;
    progression_path: string[];
    skill_coverage: { skill: string; status: string }[];
    skill_gaps: string[];
}

export interface SalaryBenchmark {
    id: number;
    role_title: string;
    seniority_level: string;
    location: string;
    p25: number;
    p50: number;
    p75: number;
}
