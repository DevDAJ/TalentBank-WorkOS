<?php

namespace Database\Seeders;

use App\Models\CareerSuggestion;
use App\Models\Certification;
use App\Models\Education;
use App\Models\Project;
use App\Models\SalaryBenchmark;
use App\Models\Skill;
use App\Models\User;
use App\Models\WorkExperience;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'Alex Johnson',
            'email' => 'alex@example.com',
            'phone' => '+1 (555) 123-4567',
            'location' => 'San Francisco, CA',
            'title' => 'Senior Full-Stack Engineer',
            'summary' => 'Senior Full-Stack Engineer with 6+ years of experience building scalable web applications. Proficient in React, Laravel, and cloud infrastructure. Passionate about clean code, user experience, and mentoring junior developers.',
            'website' => 'https://alexjohnson.dev',
            'linkedin_url' => 'https://linkedin.com/in/alexjohnson',
            'github_url' => 'https://github.com/alexjohnson',
        ]);

        WorkExperience::create([
            'user_id' => $user->id,
            'company' => 'TechFlow Inc.',
            'position' => 'Senior Full-Stack Engineer',
            'location' => 'San Francisco, CA',
            'start_date' => '2022-03-01',
            'end_date' => null,
            'is_current' => true,
            'description' => "Led a team of 5 engineers building a real-time analytics platform serving 2M+ users\nArchitected microservices migration reducing API latency by 40%\nImplemented CI/CD pipelines with GitHub Actions and Docker\nMentored 3 junior developers through structured code reviews and pair programming\nBuilt React component library adopted company-wide",
        ]);

        WorkExperience::create([
            'user_id' => $user->id,
            'company' => 'DataVista Corp',
            'position' => 'Full-Stack Developer',
            'location' => 'Austin, TX',
            'start_date' => '2019-06-01',
            'end_date' => '2022-02-28',
            'is_current' => false,
            'description' => "Developed and maintained 12+ customer-facing features using React and Laravel\nDesigned RESTful APIs serving 500K+ daily requests\nReduced database query times by 60% through indexing and query optimization\nCollaborated with design team to implement responsive UI components\nWrote comprehensive unit and integration tests using PHPUnit and Jest",
        ]);

        WorkExperience::create([
            'user_id' => $user->id,
            'company' => 'WebCraft Agency',
            'position' => 'Junior Developer',
            'location' => 'Remote',
            'start_date' => '2017-08-01',
            'end_date' => '2019-05-31',
            'is_current' => false,
            'description' => "Built and shipped 20+ client websites using React, Vue.js, and WordPress\nCreated reusable component library reducing development time by 30%\nIntegrated third-party APIs including Stripe, Twilio, and Google Maps\nParticipated in daily stand-ups and bi-weekly sprint planning",
        ]);

        WorkExperience::create([
            'user_id' => $user->id,
            'company' => 'PixelPerfect Design',
            'position' => 'UI/UX Design Intern',
            'location' => 'New York, NY',
            'start_date' => '2016-06-01',
            'end_date' => '2016-12-31',
            'is_current' => false,
            'description' => "Created wireframes and interactive prototypes using Figma\nConducted user research and usability testing with 50+ participants\nDesigned mobile-first interfaces for 3 client projects\nCollaborated with developers to ensure design fidelity during implementation",
        ]);

        Education::create([
            'user_id' => $user->id,
            'institution' => 'University of California, Berkeley',
            'degree' => 'Bachelor of Science',
            'field_of_study' => 'Computer Science',
            'start_date' => '2014-08-01',
            'end_date' => '2018-05-31',
            'gpa' => 3.7,
        ]);

        Education::create([
            'user_id' => $user->id,
            'institution' => 'Coursera / Google',
            'degree' => 'Professional Certificate',
            'field_of_study' => 'UX Design Fundamentals',
            'start_date' => '2017-01-01',
            'end_date' => '2017-04-30',
            'gpa' => null,
        ]);

        $skillData = [
            ['React', 'Technical', 'expert'],
            ['TypeScript', 'Technical', 'expert'],
            ['Laravel', 'Technical', 'advanced'],
            ['PHP', 'Technical', 'advanced'],
            ['Python', 'Technical', 'intermediate'],
            ['Docker', 'Technical', 'advanced'],
            ['AWS', 'Technical', 'intermediate'],
            ['PostgreSQL', 'Technical', 'advanced'],
            ['Redis', 'Technical', 'intermediate'],
            ['Figma', 'Design', 'intermediate'],
            ['UI/UX Design', 'Design', 'intermediate'],
            ['Prototyping', 'Design', 'intermediate'],
            ['Team Leadership', 'Soft', 'advanced'],
            ['Public Speaking', 'Soft', 'intermediate'],
            ['Agile/Scrum', 'Soft', 'advanced'],
        ];

        foreach ($skillData as [$name, $category, $level]) {
            Skill::create([
                'user_id' => $user->id,
                'name' => $name,
                'category' => $category,
                'proficiency_level' => $level,
            ]);
        }

        Certification::create([
            'user_id' => $user->id,
            'name' => 'AWS Certified Solutions Architect',
            'issuing_organization' => 'Amazon Web Services',
            'issue_date' => '2023-06-15',
            'expiration_date' => '2026-06-15',
            'credential_url' => 'https://aws.amazon.com/certification/',
        ]);

        Certification::create([
            'user_id' => $user->id,
            'name' => 'Google Professional Cloud Developer',
            'issuing_organization' => 'Google Cloud',
            'issue_date' => '2022-11-01',
            'expiration_date' => '2025-11-01',
            'credential_url' => 'https://cloud.google.com/certification/',
        ]);

        Project::create([
            'user_id' => $user->id,
            'name' => 'Real-Time Analytics Dashboard',
            'description' => 'Built a real-time analytics platform with live data streaming, interactive charts, and drill-down capabilities. Handles 10M+ events per day with sub-second query latency.',
            'technologies_used' => ['React', 'TypeScript', 'Laravel', 'WebSockets', 'Redis', 'PostgreSQL', 'Docker'],
            'url' => 'https://github.com/alexjohnson/analytics-dashboard',
            'start_date' => '2023-01-01',
            'end_date' => '2023-06-30',
        ]);

        Project::create([
            'user_id' => $user->id,
            'name' => 'Open Source Component Library',
            'description' => 'Created and maintained an open-source React component library with 40+ components, comprehensive documentation, and Storybook integration. 2K+ GitHub stars.',
            'technologies_used' => ['React', 'TypeScript', 'Storybook', 'Rollup', 'CSS Modules'],
            'url' => 'https://github.com/alexjohnson/ui-library',
            'start_date' => '2022-08-01',
            'end_date' => null,
        ]);

        Project::create([
            'user_id' => $user->id,
            'name' => 'E-Commerce Platform Redesign',
            'description' => 'Led frontend redesign for a mid-market e-commerce platform, improving conversion rates by 25% and reducing page load times by 45%.',
            'technologies_used' => ['React', 'Next.js', 'Tailwind CSS', 'Stripe', 'Algolia'],
            'url' => null,
            'start_date' => '2021-03-01',
            'end_date' => '2021-09-30',
        ]);

        $careerPaths = [
            [
                'suggested_role' => 'Engineering Manager',
                'description' => 'Lead engineering teams, drive technical strategy, and align engineering priorities with business goals.',
                'match_score' => 92,
                'progression_path' => ['Senior Full-Stack Engineer', 'Tech Lead', 'Engineering Manager'],
                'skill_coverage' => [
                    ['skill' => 'Team Leadership', 'status' => 'matched'],
                    ['skill' => 'Agile/Scrum', 'status' => 'matched'],
                    ['skill' => 'System Design', 'status' => 'partial'],
                    ['skill' => 'Budget Planning', 'status' => 'gap'],
                    ['skill' => 'Performance Management', 'status' => 'gap'],
                ],
                'skill_gaps' => ['Budget Planning', 'Performance Management', 'Strategic Roadmapping'],
            ],
            [
                'suggested_role' => 'Staff Software Engineer',
                'description' => 'Drive technical excellence across teams, design large-scale systems, and influence engineering culture.',
                'match_score' => 88,
                'progression_path' => ['Senior Full-Stack Engineer', 'Staff Software Engineer'],
                'skill_coverage' => [
                    ['skill' => 'System Architecture', 'status' => 'matched'],
                    ['skill' => 'Performance Optimization', 'status' => 'matched'],
                    ['skill' => 'Cross-team Collaboration', 'status' => 'partial'],
                    ['skill' => 'Technical Writing', 'status' => 'gap'],
                ],
                'skill_gaps' => ['Technical Writing', 'Advanced Distributed Systems'],
            ],
            [
                'suggested_role' => 'Principal Engineer',
                'description' => 'Define technical vision, lead org-wide initiatives, and mentor senior engineers across the company.',
                'match_score' => 75,
                'progression_path' => ['Senior Full-Stack Engineer', 'Staff Engineer', 'Principal Engineer'],
                'skill_coverage' => [
                    ['skill' => 'System Architecture', 'status' => 'matched'],
                    ['skill' => 'Mentoring', 'status' => 'matched'],
                    ['skill' => 'Org-wide Strategy', 'status' => 'gap'],
                    ['skill' => 'Executive Communication', 'status' => 'gap'],
                ],
                'skill_gaps' => ['Org-wide Strategy', 'Executive Communication', 'Advanced Distributed Systems'],
            ],
            [
                'suggested_role' => 'Full-Stack Tech Lead',
                'description' => 'Lead full-stack development teams, architect end-to-end solutions, and drive technical decision-making.',
                'match_score' => 95,
                'progression_path' => ['Senior Full-Stack Engineer', 'Full-Stack Tech Lead'],
                'skill_coverage' => [
                    ['skill' => 'React', 'status' => 'matched'],
                    ['skill' => 'Laravel', 'status' => 'matched'],
                    ['skill' => 'System Design', 'status' => 'partial'],
                    ['skill' => 'API Architecture', 'status' => 'matched'],
                    ['skill' => 'Database Design', 'status' => 'matched'],
                ],
                'skill_gaps' => ['Advanced System Design', 'Capacity Planning'],
            ],
            [
                'suggested_role' => 'Product Engineer',
                'description' => 'Combine engineering skills with product thinking to build features that users love. Own features from concept to delivery.',
                'match_score' => 82,
                'progression_path' => ['Senior Full-Stack Engineer', 'Product Engineer', 'Lead Product Engineer'],
                'skill_coverage' => [
                    ['skill' => 'UI/UX Design', 'status' => 'matched'],
                    ['skill' => 'Prototyping', 'status' => 'matched'],
                    ['skill' => 'User Research', 'status' => 'partial'],
                    ['skill' => 'Data Analysis', 'status' => 'gap'],
                    ['skill' => 'A/B Testing', 'status' => 'gap'],
                ],
                'skill_gaps' => ['Data Analysis', 'A/B Testing', 'Product Strategy'],
            ],
            [
                'suggested_role' => 'Lead Product Designer',
                'description' => 'Own the end-to-end design process, lead design strategy, and shape product direction through user-centered design.',
                'match_score' => 65,
                'progression_path' => ['UI/UX Design Intern', 'Product Designer', 'Senior Product Designer', 'Lead Product Designer'],
                'skill_coverage' => [
                    ['skill' => 'Figma', 'status' => 'matched'],
                    ['skill' => 'UI/UX Design', 'status' => 'matched'],
                    ['skill' => 'User Research', 'status' => 'partial'],
                    ['skill' => 'Design Systems', 'status' => 'gap'],
                    ['skill' => 'Motion Design', 'status' => 'gap'],
                ],
                'skill_gaps' => ['Design Systems', 'Motion Design', 'Advanced Prototyping', 'Design Operations'],
            ],
            [
                'suggested_role' => 'DevOps / Platform Engineer',
                'description' => 'Build and maintain the infrastructure that enables engineering teams to deploy reliably and scale efficiently.',
                'match_score' => 70,
                'progression_path' => ['Senior Full-Stack Engineer', 'DevOps Engineer', 'Platform Engineer'],
                'skill_coverage' => [
                    ['skill' => 'Docker', 'status' => 'matched'],
                    ['skill' => 'AWS', 'status' => 'matched'],
                    ['skill' => 'CI/CD', 'status' => 'matched'],
                    ['skill' => 'Kubernetes', 'status' => 'gap'],
                    ['skill' => 'Terraform', 'status' => 'gap'],
                ],
                'skill_gaps' => ['Kubernetes', 'Terraform', 'Infrastructure as Code', 'Monitoring/Observability'],
            ],
        ];

        foreach ($careerPaths as $path) {
            CareerSuggestion::create(array_merge($path, ['user_id' => $user->id]));
        }

        $ahmad = User::factory()->create([
            'name' => 'Ahmad Abidin',
            'email' => 'ahmad@example.com',
            'phone' => '+60 12-345 6789',
            'location' => 'Kuala Lumpur, Malaysia',
            'title' => 'Backend Developer',
            'summary' => 'Backend Developer with 4+ years of experience designing and building scalable APIs and microservices. Proficient in Laravel, Go, and cloud-native technologies. Strong focus on system architecture, database optimization, and clean code principles.',
            'website' => 'https://ahmadabidin.dev',
            'linkedin_url' => 'https://linkedin.com/in/ahmadabidin',
            'github_url' => 'https://github.com/ahmadabidin',
        ]);

        WorkExperience::create([
            'user_id' => $ahmad->id,
            'company' => 'Paywave Technologies',
            'position' => 'Backend Developer',
            'location' => 'Kuala Lumpur, Malaysia',
            'start_date' => '2023-01-01',
            'end_date' => null,
            'is_current' => true,
            'description' => "Designed and built payment processing microservices handling 500K+ transactions daily\nOptimized PostgreSQL queries reducing average response time by 55%\nImplemented Redis caching layer improving API throughput by 3x\nBuilt event-driven architecture using RabbitMQ for async job processing\nAuthored API documentation used by 3 external integration teams",
        ]);

        WorkExperience::create([
            'user_id' => $ahmad->id,
            'company' => 'TechGrowth MY',
            'position' => 'Junior Backend Engineer',
            'location' => 'Selangor, Malaysia',
            'start_date' => '2021-03-01',
            'end_date' => '2022-12-31',
            'is_current' => false,
            'description' => "Developed RESTful APIs for e-commerce platform serving 200K+ monthly active users\nMigrated legacy monolith to Laravel-based modular architecture\nImplemented automated testing pipeline achieving 85% code coverage\nManaged MySQL database replication and backup strategies\nCollaborated with frontend team on API contract design",
        ]);

        WorkExperience::create([
            'user_id' => $ahmad->id,
            'company' => 'Digital Solutions Sdn Bhd',
            'position' => 'Software Engineer Intern',
            'location' => 'Kuala Lumpur, Malaysia',
            'start_date' => '2020-06-01',
            'end_date' => '2020-12-31',
            'is_current' => false,
            'description' => "Built internal tools using Laravel and Vue.js reducing manual reporting by 40%\nWrote unit and integration tests with PHPUnit\nAssisted in server maintenance and deployment automation\nParticipated in code reviews and agile ceremonies",
        ]);

        Education::create([
            'user_id' => $ahmad->id,
            'institution' => 'Universiti Malaya',
            'degree' => 'Bachelor of Computer Science',
            'field_of_study' => 'Software Engineering',
            'start_date' => '2017-09-01',
            'end_date' => '2021-06-30',
            'gpa' => 3.65,
        ]);

        $ahmadSkills = [
            ['Laravel', 'Technical', 'expert'],
            ['PHP', 'Technical', 'expert'],
            ['Go', 'Technical', 'advanced'],
            ['PostgreSQL', 'Technical', 'expert'],
            ['MySQL', 'Technical', 'advanced'],
            ['Redis', 'Technical', 'advanced'],
            ['RabbitMQ', 'Technical', 'intermediate'],
            ['Docker', 'Technical', 'advanced'],
            ['Kubernetes', 'Technical', 'intermediate'],
            ['AWS', 'Technical', 'advanced'],
            ['REST API Design', 'Technical', 'expert'],
            ['Git', 'Technical', 'advanced'],
        ];

        foreach ($ahmadSkills as [$name, $category, $level]) {
            Skill::create(['user_id' => $ahmad->id, 'name' => $name, 'category' => $category, 'proficiency_level' => $level]);
        }

        Certification::create([
            'user_id' => $ahmad->id,
            'name' => 'AWS Certified Developer – Associate',
            'issuing_organization' => 'Amazon Web Services',
            'issue_date' => '2024-02-15',
            'expiration_date' => '2027-02-15',
            'credential_url' => 'https://aws.amazon.com/certification/',
        ]);

        Certification::create([
            'user_id' => $ahmad->id,
            'name' => 'Laravel Certified Developer',
            'issuing_organization' => 'Laravel Certification',
            'issue_date' => '2023-08-01',
            'expiration_date' => null,
            'credential_url' => null,
        ]);

        Project::create([
            'user_id' => $ahmad->id,
            'name' => 'Payment Gateway Microservice',
            'description' => 'Built a scalable payment gateway handling multi-currency transactions with idempotency, retry logic, and webhook delivery. Processed $50M+ in transaction volume.',
            'technologies_used' => ['Go', 'PostgreSQL', 'Redis', 'RabbitMQ', 'Docker', 'Kubernetes'],
            'url' => 'https://github.com/ahmadabidin/payment-gateway',
            'start_date' => '2023-06-01',
            'end_date' => '2024-01-31',
        ]);

        Project::create([
            'user_id' => $ahmad->id,
            'name' => 'API Rate Limiter Package',
            'description' => 'Open-source Laravel package for distributed rate limiting with Redis backend. Supports sliding window, token bucket, and concurrent request limiting. 500+ GitHub stars.',
            'technologies_used' => ['PHP', 'Laravel', 'Redis'],
            'url' => 'https://github.com/ahmadabidin/laravel-rate-limiter',
            'start_date' => '2023-03-01',
            'end_date' => null,
        ]);

        $ahmadCareerPaths = [
            [
                'suggested_role' => 'Senior Backend Engineer',
                'description' => 'Lead backend architecture decisions, mentor junior engineers, and own critical infrastructure components.',
                'match_score' => 94,
                'progression_path' => ['Backend Developer', 'Senior Backend Engineer', 'Staff Engineer'],
                'skill_coverage' => [
                    ['skill' => 'Laravel', 'status' => 'matched'],
                    ['skill' => 'PostgreSQL', 'status' => 'matched'],
                    ['skill' => 'System Design', 'status' => 'partial'],
                    ['skill' => 'Mentoring', 'status' => 'gap'],
                    ['skill' => 'Technical Writing', 'status' => 'gap'],
                ],
                'skill_gaps' => ['System Design at Scale', 'Mentoring', 'Technical Writing'],
            ],
            [
                'suggested_role' => 'DevOps / Platform Engineer',
                'description' => 'Build and maintain infrastructure platforms, automate deployments, and enable developer productivity.',
                'match_score' => 82,
                'progression_path' => ['Backend Developer', 'DevOps Engineer', 'Platform Engineer'],
                'skill_coverage' => [
                    ['skill' => 'Docker', 'status' => 'matched'],
                    ['skill' => 'Kubernetes', 'status' => 'matched'],
                    ['skill' => 'AWS', 'status' => 'matched'],
                    ['skill' => 'Terraform', 'status' => 'gap'],
                    ['skill' => 'CI/CD', 'status' => 'partial'],
                ],
                'skill_gaps' => ['Terraform', 'Advanced Kubernetes', 'Observability Stack'],
            ],
            [
                'suggested_role' => 'Software Architect',
                'description' => 'Define technical vision, design system architecture, and guide technology decisions across teams.',
                'match_score' => 72,
                'progression_path' => ['Backend Developer', 'Senior Backend Engineer', 'Software Architect'],
                'skill_coverage' => [
                    ['skill' => 'System Design', 'status' => 'partial'],
                    ['skill' => 'API Architecture', 'status' => 'matched'],
                    ['skill' => 'Database Design', 'status' => 'matched'],
                    ['skill' => 'Distributed Systems', 'status' => 'gap'],
                    ['skill' => 'Executive Communication', 'status' => 'gap'],
                ],
                'skill_gaps' => ['Distributed Systems', 'Executive Communication', 'Domain-Driven Design'],
            ],
        ];

        foreach ($ahmadCareerPaths as $path) {
            CareerSuggestion::create(array_merge($path, ['user_id' => $ahmad->id]));
        }

        $nur = User::factory()->create([
            'name' => 'Nur Kekwa',
            'email' => 'nur@example.com',
            'phone' => '+60 16-234 5678',
            'location' => 'Penang, Malaysia',
            'title' => 'Product Designer',
            'summary' => 'Product Designer with 5+ years of experience crafting user-centered digital products. Skilled in end-to-end design from user research to high-fidelity prototypes. Passionate about design systems, accessibility, and bridging the gap between design and development.',
            'website' => 'https://nurkekwa.design',
            'linkedin_url' => 'https://linkedin.com/in/nurkekwa',
            'github_url' => 'https://github.com/nurkekwa',
        ]);

        WorkExperience::create([
            'user_id' => $nur->id,
            'company' => 'Shape Studio',
            'position' => 'Product Designer',
            'location' => 'Penang, Malaysia',
            'start_date' => '2022-04-01',
            'end_date' => null,
            'is_current' => true,
            'description' => "Led product design for SaaS platform serving 100K+ users across SEA\nEstablished design system adopted by 3 product teams, reducing design-to-dev handoff time by 40%\nConducted user research sessions with 80+ stakeholders across 5 markets\nDesigned and shipped 30+ major features from concept to launch\nImproved NPS score from 42 to 68 through UX improvements",
        ]);

        WorkExperience::create([
            'user_id' => $nur->id,
            'company' => 'Kreatif Digital Agency',
            'position' => 'UI/UX Designer',
            'location' => 'Kuala Lumpur, Malaysia',
            'start_date' => '2020-01-01',
            'end_date' => '2022-03-31',
            'is_current' => false,
            'description' => "Designed responsive web apps and mobile interfaces for 15+ clients across fintech, edutech, and e-commerce\nCreated interactive prototypes and design specifications using Figma\nPlanned and facilitated usability testing sessions\nCollaborated with developers to ensure pixel-perfect implementation\nRedefined client onboarding process reducing churn by 25%",
        ]);

        WorkExperience::create([
            'user_id' => $nur->id,
            'company' => 'WebCraft Agency',
            'position' => 'Junior Designer',
            'location' => 'Penang, Malaysia',
            'start_date' => '2018-06-01',
            'end_date' => '2019-12-31',
            'is_current' => false,
            'description' => "Created marketing materials, social media graphics, and landing page designs\nAssisted senior designers on web and mobile app projects\nLearned user research methodologies and design thinking process\nBuilt and maintained client style guides and asset libraries",
        ]);

        Education::create([
            'user_id' => $nur->id,
            'institution' => 'Universiti Sains Malaysia',
            'degree' => 'Bachelor of Arts',
            'field_of_study' => 'Graphic Design',
            'start_date' => '2014-09-01',
            'end_date' => '2018-06-30',
            'gpa' => 3.52,
        ]);

        Education::create([
            'user_id' => $nur->id,
            'institution' => 'Interaction Design Foundation',
            'degree' => 'Professional Certificate',
            'field_of_study' => 'UX Management',
            'start_date' => '2021-01-01',
            'end_date' => '2021-06-30',
            'gpa' => null,
        ]);

        $nurSkills = [
            ['Figma', 'Design', 'expert'],
            ['UI/UX Design', 'Design', 'expert'],
            ['Design Systems', 'Design', 'advanced'],
            ['Wireframing', 'Design', 'expert'],
            ['Prototyping', 'Design', 'expert'],
            ['User Research', 'Design', 'advanced'],
            ['Usability Testing', 'Design', 'advanced'],
            ['Interaction Design', 'Design', 'advanced'],
            ['Design Thinking', 'Design', 'expert'],
            ['HTML/CSS', 'Technical', 'intermediate'],
            ['React', 'Technical', 'beginner'],
            ['Adobe Creative Suite', 'Design', 'advanced'],
            ['Motion Design', 'Design', 'intermediate'],
            ['Storytelling', 'Soft', 'advanced'],
            ['Stakeholder Management', 'Soft', 'advanced'],
        ];

        foreach ($nurSkills as [$name, $category, $level]) {
            Skill::create(['user_id' => $nur->id, 'name' => $name, 'category' => $category, 'proficiency_level' => $level]);
        }

        Certification::create([
            'user_id' => $nur->id,
            'name' => 'Google UX Design Professional Certificate',
            'issuing_organization' => 'Coursera / Google',
            'issue_date' => '2021-12-01',
            'expiration_date' => null,
            'credential_url' => 'https://coursera.org/verify/professional-cert/ux-design',
        ]);

        Certification::create([
            'user_id' => $nur->id,
            'name' => 'NN/g UX Certification',
            'issuing_organization' => 'Nielsen Norman Group',
            'issue_date' => '2023-03-15',
            'expiration_date' => '2026-03-15',
            'credential_url' => 'https://nngroup.com/certification/',
        ]);

        Project::create([
            'user_id' => $nur->id,
            'name' => 'Fintech App Redesign',
            'description' => 'Complete redesign of a mobile banking app serving 500K+ users. Reduced task completion time by 35% and improved accessibility score from 72 to 94.',
            'technologies_used' => ['Figma', 'Prototyping', 'User Research', 'Design Systems'],
            'url' => 'https://dribbble.com/nurkekwa/fintech-redesign',
            'start_date' => '2023-03-01',
            'end_date' => '2023-08-31',
        ]);

        Project::create([
            'user_id' => $nur->id,
            'name' => 'Design System — Orbit',
            'description' => 'Built a comprehensive design system with 120+ components, accessibility guidelines, and developer documentation. Adopted by 4 product teams across the organization.',
            'technologies_used' => ['Figma', 'Design Tokens', 'Storybook', 'React'],
            'url' => null,
            'start_date' => '2022-08-01',
            'end_date' => '2023-02-28',
        ]);

        Project::create([
            'user_id' => $nur->id,
            'name' => 'Edutech Platform UX Research',
            'description' => 'Led a 3-month UX research initiative for an online learning platform. Identified 15 key pain points and proposed solutions that increased course completion rates by 28%.',
            'technologies_used' => ['User Research', 'Usability Testing', 'Data Analysis'],
            'url' => 'https://nurkekwa.design/case-studies/edutech',
            'start_date' => '2022-01-01',
            'end_date' => '2022-03-31',
        ]);

        $nurCareerPaths = [
            [
                'suggested_role' => 'Senior Product Designer',
                'description' => 'Lead complex design initiatives, mentor junior designers, and drive design strategy across products.',
                'match_score' => 93,
                'progression_path' => ['Product Designer', 'Senior Product Designer', 'Lead Product Designer'],
                'skill_coverage' => [
                    ['skill' => 'UI/UX Design', 'status' => 'matched'],
                    ['skill' => 'Design Systems', 'status' => 'matched'],
                    ['skill' => 'User Research', 'status' => 'matched'],
                    ['skill' => 'Mentoring', 'status' => 'gap'],
                    ['skill' => 'Design Ops', 'status' => 'gap'],
                ],
                'skill_gaps' => ['Mentoring', 'Design Operations', 'Advanced Prototyping Tools'],
            ],
            [
                'suggested_role' => 'Design Engineer',
                'description' => 'Bridge the gap between design and engineering. Build design tools, component libraries, and design-to-code workflows.',
                'match_score' => 76,
                'progression_path' => ['Product Designer', 'Design Engineer', 'Creative Technologist'],
                'skill_coverage' => [
                    ['skill' => 'Figma', 'status' => 'matched'],
                    ['skill' => 'Design Systems', 'status' => 'matched'],
                    ['skill' => 'HTML/CSS', 'status' => 'matched'],
                    ['skill' => 'React', 'status' => 'partial'],
                    ['skill' => 'Storybook', 'status' => 'gap'],
                ],
                'skill_gaps' => ['Advanced React', 'Storybook', 'Design Token Architecture'],
            ],
            [
                'suggested_role' => 'UX Research Lead',
                'description' => 'Own the research practice, define research methodologies, and drive data-informed product decisions.',
                'match_score' => 80,
                'progression_path' => ['Product Designer', 'UX Researcher', 'UX Research Lead'],
                'skill_coverage' => [
                    ['skill' => 'User Research', 'status' => 'matched'],
                    ['skill' => 'Usability Testing', 'status' => 'matched'],
                    ['skill' => 'Data Analysis', 'status' => 'partial'],
                    ['skill' => 'Statistical Analysis', 'status' => 'gap'],
                    ['skill' => 'Research Ops', 'status' => 'gap'],
                ],
                'skill_gaps' => ['Statistical Analysis', 'Research Operations', 'Quantitative Research Methods'],
            ],
            [
                'suggested_role' => 'Design Operations Manager',
                'description' => 'Streamline design processes, tools, and workflows to enable design teams to work more effectively at scale.',
                'match_score' => 72,
                'progression_path' => ['Product Designer', 'Design Ops Specialist', 'Design Operations Manager'],
                'skill_coverage' => [
                    ['skill' => 'Design Systems', 'status' => 'matched'],
                    ['skill' => 'Stakeholder Management', 'status' => 'matched'],
                    ['skill' => 'Process Design', 'status' => 'partial'],
                    ['skill' => 'Budget Planning', 'status' => 'gap'],
                    ['skill' => 'Vendor Management', 'status' => 'gap'],
                ],
                'skill_gaps' => ['Budget Planning', 'Vendor Management', 'Change Management'],
            ],
        ];

        foreach ($nurCareerPaths as $path) {
            CareerSuggestion::create(array_merge($path, ['user_id' => $nur->id]));
        }

        $roles = [
            ['Frontend Engineer', 'Software Engineering'],
            ['Backend Engineer', 'Software Engineering'],
            ['Full-Stack Engineer', 'Software Engineering'],
            ['Product Designer', 'UI/UX Design'],
            ['UX Researcher', 'UI/UX Design'],
            ['Design Engineer', 'UI/UX Design'],
        ];

        $seniorities = ['junior', 'mid', 'senior', 'lead'];
        $locations = ['San Francisco, CA', 'New York, NY', 'Austin, TX', 'Remote US', 'Remote Global'];

        $baseSalaryByRole = [
            'Frontend Engineer' => [90000, 120000, 160000, 200000],
            'Backend Engineer' => [95000, 130000, 170000, 210000],
            'Full-Stack Engineer' => [100000, 135000, 175000, 220000],
            'Product Designer' => [80000, 110000, 145000, 180000],
            'UX Researcher' => [75000, 100000, 135000, 170000],
            'Design Engineer' => [85000, 115000, 155000, 190000],
        ];

        $locationMultiplier = [
            'San Francisco, CA' => 1.3,
            'New York, NY' => 1.25,
            'Austin, TX' => 1.1,
            'Remote US' => 1.0,
            'Remote Global' => 0.85,
        ];

        foreach ($roles as [$role, $industry]) {
            foreach ($seniorities as $idx => $seniority) {
                $base = $baseSalaryByRole[$role][$idx];
                foreach ($locations as $loc) {
                    $mult = $locationMultiplier[$loc];
                    $p50 = (int) round($base * $mult);
                    $p25 = (int) round($p50 * 0.85);
                    $p75 = (int) round($p50 * 1.15);

                    SalaryBenchmark::create([
                        'role_title' => $role,
                        'seniority_level' => $seniority,
                        'location' => $loc,
                        'p25' => $p25,
                        'p50' => $p50,
                        'p75' => $p75,
                    ]);
                }
            }
        }
    }
}
