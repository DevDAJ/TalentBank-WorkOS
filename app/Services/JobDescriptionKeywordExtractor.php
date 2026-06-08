<?php

namespace App\Services;

class JobDescriptionKeywordExtractor
{
    private const STOP_WORDS = [
        'the', 'a', 'an', 'and', 'or', 'but', 'in', 'on', 'at', 'to', 'for', 'of', 'with', 'by',
        'is', 'are', 'was', 'were', 'be', 'been', 'being', 'have', 'has', 'had', 'do', 'does', 'did',
        'will', 'would', 'could', 'should', 'may', 'might', 'shall', 'can', 'need', 'must', 'about',
        'into', 'over', 'after', 'before', 'between', 'under', 'above', 'this', 'that', 'these',
        'those', 'we', 'our', 'you', 'your', 'their', 'its', 'what', 'which', 'who', 'whom', 'when',
        'where', 'how', 'all', 'each', 'every', 'both', 'few', 'more', 'most', 'other', 'some', 'such',
        'no', 'nor', 'not', 'only', 'own', 'same', 'so', 'than', 'too', 'very', 'just', 'also', 'now',
        'here', 'there', 'then', 'once', 'from', 'as', 'if', 'while', 'during', 'through', 'against',
        'among', 'throughout', 'despite', 'towards', 'upon', 'within', 'without', 'along', 'across',
        'behind', 'beyond', 'plus', 'via', 'per', 'able', 'using', 'used', 'use', 'make', 'made',
        'help', 'ensure', 'work', 'works', 'worked', 'working', 'join', 'looking', 'seeking', 'hire',
        'hiring', 'apply', 'candidate', 'candidates', 'position', 'role', 'title', 'description',
        'responsibilities', 'requirements', 'qualifications', 'preferred', 'experience', 'experienced',
        'years', 'year', 'month', 'day', 'time', 'team', 'company', 'based', 'location', 'office',
        'remote', 'hybrid', 'onsite', 'opportunity', 'including', 'including', 'well', 'strong',
        'excellent', 'good', 'great', 'highly', 'ability', 'skills', 'skill', 'knowledge', 'understanding',
        'building', 'developing', 'development', 'software', 'industry', 'serves', 'beating', 'financial',
        'any', 'new', 'best', 'joining', 'lead', 'leading', 'manage', 'managing', 'support', 'supporting',
        'create', 'creating', 'deliver', 'delivering', 'drive', 'driving', 'maintain', 'maintaining',
        'design', 'designed', 'implement', 'implementing', 'provide', 'providing', 'perform', 'performing',
        'databases', 'database', 'solutions', 'solution', 'services', 'service', 'products', 'product',
        'applications', 'application', 'systems', 'system', 'process', 'processes', 'environment',
        'environments', 'practices', 'practice', 'standards', 'standard', 'quality', 'performance',
        'security', 'scalable', 'reliable', 'efficient', 'effective', 'innovative', 'dynamic', 'fast',
        'paced', 'global', 'local', 'international', 'world', 'class', 'level', 'mid', 'senior', 'junior',
        'dont', 'don', 'll', 've', 're', 'd', 's', 't', 'm', 'kuala', 'lumpur',
        'malaysia', 'singapore', 'london', 'street', 'avenue', 'city', 'country', 'region', 'area',
        'mid-level', 'midlevel', 'entry-level', 'full-time', 'part-time', 'cross-functional', 'fullstack',
    ];

    private const MULTI_WORD_TERMS = [
        'machine learning', 'deep learning', 'data science', 'rest api', 'rest apis', 'graphql api',
        'spring boot', 'ruby on rails', 'react native', 'next.js', 'nextjs', 'node.js', 'nodejs',
        'vue.js', 'vuejs', 'angular.js', 'express.js', 'asp.net', '.net', 'c++', 'c#', 'ci/cd',
        'unit testing', 'integration testing', 'agile scrum', 'ui/ux', 'amazon web services',
        'google cloud', 'microsoft azure', 'object oriented', 'micro services', 'microservices',
        'event driven', 'test driven', 'pair programming', 'code review', 'pull request',
    ];

    private const TECH_LEXICON = [
        'api', 'apis', 'rest', 'graphql', 'grpc', 'soap', 'json', 'xml', 'yaml', 'http', 'https', 'oauth',
        'jwt', 'ssl', 'tls', 'tcp', 'udp', 'dns', 'cdn', 'sdk', 'cli', 'ide', 'git', 'github', 'gitlab',
        'bitbucket', 'jira', 'confluence', 'slack', 'figma', 'sketch', 'zeplin', 'postman', 'swagger',
        'openapi', 'java', 'javascript', 'typescript', 'python', 'ruby', 'php', 'golang', 'rust', 'scala',
        'kotlin', 'swift', 'objective', 'csharp', 'dotnet', 'elixir', 'haskell', 'clojure', 'perl', 'lua',
        'dart', 'flutter', 'react', 'vue', 'angular', 'svelte', 'nextjs', 'nuxt', 'remix', 'gatsby',
        'redux', 'mobx', 'zustand', 'tailwind', 'bootstrap', 'sass', 'less', 'webpack', 'vite', 'rollup',
        'babel', 'eslint', 'prettier', 'jest', 'mocha', 'cypress', 'playwright', 'selenium', 'pytest',
        'junit', 'rspec', 'phpunit', 'laravel', 'symfony', 'django', 'flask', 'fastapi', 'rails',
        'spring', 'hibernate', 'express', 'nestjs', 'fastify', 'koa', 'gin', 'echo', 'fiber', 'actix',
        'mysql', 'postgresql', 'postgres', 'mongodb', 'redis', 'elasticsearch', 'dynamodb', 'cassandra',
        'sqlite', 'mariadb', 'oracle', 'sqlserver', 'snowflake', 'bigquery', 'redshift', 'firebase',
        'supabase', 'prisma', 'sequelize', 'typeorm', 'mongoose', 'kafka', 'rabbitmq', 'sqs', 'sns',
        'docker', 'kubernetes', 'k8s', 'helm', 'terraform', 'ansible', 'puppet', 'chef', 'jenkins',
        'circleci', 'travis', 'github actions', 'gitlab ci', 'argocd', 'prometheus', 'grafana',
        'datadog', 'sentry', 'newrelic', 'elk', 'logstash', 'kibana', 'splunk', 'aws', 'gcp', 'azure',
        'ec2', 's3', 'lambda', 'ecs', 'eks', 'fargate', 'cloudfront', 'route53', 'iam', 'vpc', 'rds',
        'cloudwatch', 'cloudformation', 'serverless', 'microservices', 'server', 'linux', 'unix',
        'ubuntu', 'debian', 'centos', 'nginx', 'apache', 'tomcat', 'websocket', 'websockets', 'grpc',
        'rabbitmq', 'memcached', 'varnish', 'haproxy', 'nosql', 'sql', 'etl', 'elt', 'spark', 'hadoop',
        'airflow', 'dbt', 'pandas', 'numpy', 'tensorflow', 'pytorch', 'scikit', 'opencv', 'tableau',
        'powerbi', 'looker', 'metabase', 'agile', 'scrum', 'kanban', 'devops', 'devsecops', 'sre',
        'tdd', 'bdd', 'oop', 'mvc', 'mvvm', 'solid', 'dry', 'kiss', 'blockchain', 'web3',
        'solidity', 'ethereum', 'bitcoin', 'nft', 'ios', 'android', 'mobile', 'frontend', 'backend',
        'fullstack', 'full-stack', 'saas', 'paas', 'iaas', 'crm', 'erp', 'cms', 'seo', 'sem',
    ];

    public function extract(string $text, array $userSkillNames = []): array
    {
        $normalized = $this->normalizeText($text);
        $focusText = $this->extractFocusSections($normalized) ?? $normalized;
        $userTokens = $this->expandSkillTokens($userSkillNames);
        $scores = [];

        $compoundTerms = [];

        foreach (self::MULTI_WORD_TERMS as $term) {
            if (!str_contains($focusText, $term)) {
                continue;
            }

            $keyword = $this->normalizeToken($term);
            if ($keyword) {
                $scores[$keyword] = ($scores[$keyword] ?? 0) + 8;
                $compoundTerms[] = $keyword;
            }
        }

        preg_match_all('/\b[a-z0-9][a-z0-9.+#\/-]*\b/i', $focusText, $matches);

        foreach ($matches[0] as $raw) {
            $keyword = $this->normalizeToken($raw);
            if (!$keyword || !$this->isRelevantKeyword($keyword, $raw, $userTokens)) {
                continue;
            }

            if ($this->isPartOfCompoundTerm($keyword, $compoundTerms)) {
                continue;
            }

            $score = 1;

            if (in_array($keyword, self::TECH_LEXICON, true)) {
                $score += 4;
            }

            if ($this->matchesUserSkill($keyword, $userTokens)) {
                $score += 3;
            }

            if (preg_match('/[.+#\/-]|\d/', $raw)) {
                $score += 2;
            }

            if (strlen($raw) <= 6 && preg_match('/^[A-Z0-9+#.]+$/', $raw)) {
                $score += 2;
            }

            $scores[$keyword] = ($scores[$keyword] ?? 0) + $score;
        }

        arsort($scores);

        return array_slice(array_keys($scores), 0, 20);
    }

    public function matchAgainstSkills(array $keywords, array $userSkillNames): array
    {
        $userTokens = $this->expandSkillTokens($userSkillNames);
        $matched = [];
        $missing = [];

        foreach ($keywords as $keyword) {
            if ($this->matchesUserSkill($keyword, $userTokens)) {
                $matched[] = $keyword;
            } else {
                $missing[] = $keyword;
            }
        }

        return [$matched, $missing];
    }

    private function normalizeText(string $text): string
    {
        $text = mb_strtolower($text);
        $text = str_replace(["\u{2019}", '`', '´'], "'", $text);
        $text = preg_replace("/(\w)'(?:s|t|re|ve|ll|d)\b/", '$1', $text);
        $text = preg_replace("/[^a-z0-9+#.\/\s-]/", ' ', $text);
        $text = preg_replace('/\s+/', ' ', $text);

        return trim($text);
    }

    private function extractFocusSections(string $text): ?string
    {
        $sectionPattern = '/(?:^|\n)\s*(?:'
            . 'requirements?|qualifications?|skills?(?:\s+required)?|must\s+have|nice\s+to\s+have|'
            . 'tech(?:nical)?\s+stack|technologies?|what\s+you(?:\'ll)?\s+bring|what\s+we(?:\'re)?\s+looking\s+for'
            . ')\s*[:\-]?\s*(.*?)(?=\n\s*(?:'
            . 'requirements?|qualifications?|skills?|must\s+have|nice\s+to\s+have|benefits?|about\s+us|'
            . 'who\s+we\s+are|responsibilities|description|overview'
            . ')\s*[:\-]?|\z)/is';

        if (!preg_match_all($sectionPattern, $text, $matches)) {
            return null;
        }

        $sections = trim(implode(' ', $matches[1]));

        return $sections !== '' ? $sections : null;
    }

    private function normalizeToken(string $raw): ?string
    {
        $token = strtolower(trim($raw));

        $aliases = [
            'apis' => 'api',
            'rest apis' => 'rest api',
            'postgres' => 'postgresql',
            'k8s' => 'kubernetes',
            'nodejs' => 'node.js',
            'nextjs' => 'next.js',
            'vuejs' => 'vue',
            'golang' => 'go',
        ];

        return $aliases[$token] ?? $token;
    }

    private function isRelevantKeyword(string $keyword, string $raw, array $userTokens): bool
    {
        if (strlen($keyword) < 2) {
            return false;
        }

        if (in_array($keyword, self::STOP_WORDS, true)) {
            return false;
        }

        if (preg_match('/^\d+$/', $keyword)) {
            return false;
        }

        if (in_array($keyword, self::TECH_LEXICON, true)) {
            return true;
        }

        if ($this->matchesUserSkill($keyword, $userTokens)) {
            return true;
        }

        if (preg_match('/[.+#\/-]|\d/', $raw)) {
            return true;
        }

        if (strlen($raw) <= 6 && preg_match('/^[A-Z0-9+#.]+$/', $raw)) {
            return true;
        }

        return false;
    }

    private function expandSkillTokens(array $skillNames): array
    {
        $tokens = [];

        foreach ($skillNames as $name) {
            $name = strtolower(trim($name));
            if ($name === '') {
                continue;
            }

            $tokens[] = $name;

            foreach (preg_split('/[\s\/,&+]+/', $name) as $part) {
                $part = trim($part);
                if (strlen($part) >= 2) {
                    $tokens[] = $this->normalizeToken($part);
                }
            }
        }

        return array_values(array_unique(array_filter($tokens)));
    }

    private function isPartOfCompoundTerm(string $keyword, array $compoundTerms): bool
    {
        foreach ($compoundTerms as $compound) {
            if (str_contains($compound, $keyword) && $compound !== $keyword) {
                return true;
            }
        }

        return false;
    }

    private function matchesUserSkill(string $keyword, array $userTokens): bool
    {
        foreach ($userTokens as $token) {
            if ($keyword === $token) {
                return true;
            }

            if (strlen($keyword) >= 4 && (str_contains($token, $keyword) || str_contains($keyword, $token))) {
                return true;
            }
        }

        return false;
    }
}
