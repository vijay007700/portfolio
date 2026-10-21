<?php

namespace Database\Seeders;

use App\Models\Integration;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $adminEmail = env('ADMIN_EMAIL', 'admin@portfolio.test');
        $adminPassword = env('ADMIN_PASSWORD', 'Admin@123');

        if (app()->environment('production') && ($adminEmail === 'admin@portfolio.test' || $adminPassword === 'Admin@123')) {
            throw new \RuntimeException('Set a unique ADMIN_EMAIL and ADMIN_PASSWORD before seeding production.');
        }

        User::firstOrCreate(
            ['email' => $adminEmail],
            [
                'name' => env('ADMIN_NAME', 'Portfolio Admin'),
                'password' => Hash::make($adminPassword),
            ]
        );

        // Seed the starter portfolio on a fresh deployment when explicitly enabled.
        // Existing admin-edited content is left intact on subsequent starts.
        $seedPortfolioContent = filter_var(env('SEED_PORTFOLIO_CONTENT', !app()->environment('production')), FILTER_VALIDATE_BOOL);
        if (!$seedPortfolioContent || Profile::query()->exists()) {
            return;
        }

        Profile::firstOrCreate(['id' => 1], [
            'name' => 'Vijay Thakur',
            'title' => 'Full-Stack Developer | Laravel, PHP & Node.js',
            'hero_title' => 'I build web products, mobile APIs and real-time features.',
            'hero_subtitle' => 'Full-stack developer with 4.5 years of experience and work across 7+ Laravel websites, including a B2B e-commerce project for PC Exporters. I also build mobile APIs, real-time Node.js features and custom WordPress websites.',
            'bio' => 'I am a full-stack web developer with 4.5 years of overall experience across Laravel, Core PHP, CodeIgniter, Node.js, Vue.js, React and WordPress. I have worked on 7+ Laravel websites, including a B2B e-commerce project for PC Exporters, and built mobile APIs used by 30+ apps. My Node.js work includes socket-based chat and video-call features. My WordPress work includes 10+ winery websites and a client-tailored quiz setup using Tutor LMS. I have also worked on Milk Club, Motion Tyre, Lewis & Clark Winery and Lake Creek Winery.',
            'email' => null,
            'phone' => null,
            'location' => null,
            'resume_url' => null,
            'github_url' => null,
            'linkedin_url' => null,
            'upwork_url' => null,
            'years_experience' => 4.5,
            'apps_apis' => 30,
            'websites' => 7,
            'wordpress_sites' => 10,
            'availability' => null,
        ]);

        $skills = [
            ['Laravel', 'Backend development', 'LA', 4.5],
            ['Core PHP', 'Backend development', 'PHP', 2],
            ['CodeIgniter', 'Backend development', 'CI', 2],
            ['Node.js', 'Backend development', 'JS', 1],
            ['REST APIs', 'Backend development', 'API', null],
            ['Vue.js', 'Frontend development', 'VUE', 1],
            ['React', 'Frontend development', 'RE', 1],
            ['WordPress', 'CMS & e-learning', 'WP', 1],
            ['Tutor LMS', 'CMS & e-learning', 'LMS', null],
            ['MySQL', 'Databases', 'DB', null],
            ['HTML, CSS and JavaScript', 'Frontend fundamentals', 'WEB', null],
            ['Git', 'Development workflow', 'GIT', null],
            ['SQLite', 'Databases', 'SQL', null],
            ['MongoDB', 'Databases', 'MDB', null],
            ['Supabase', 'Databases', 'SB', null],
            ['Firebase', 'Databases', 'FB', null],
        ];

        foreach ($skills as $index => [$name, $category, $icon, $years]) {
            Skill::firstOrCreate(['name' => $name], [
                'name' => $name,
                'category' => $category,
                'level' => null,
                'years' => $years,
                'icon' => $icon,
                'sort_order' => $index,
                'is_active' => true,
            ]);
        }

        $services = [
            ['LAR', 'Laravel websites & B2B e-commerce', 'Work across 7+ Laravel websites, including a B2B e-commerce project for PC Exporters.', 'Build Laravel websites and backend workflows around client requirements, including B2B e-commerce.'],
            ['API', 'Mobile API development', 'Laravel APIs built to support mobile applications, including work for 30+ apps.', 'Develop application APIs to connect mobile clients with their backend services.'],
            ['JS', 'Node.js real-time features', 'Socket-based chat and video-call functionality for interactive products.', 'Build real-time application features using Node.js and socket connections.'],
            ['WP', 'WordPress websites & Tutor LMS', 'Client-specific WordPress websites, winery sites and quiz experiences.', 'Customize WordPress websites to meet client requirements, including quiz setups using Tutor LMS.'],
            ['UI', 'Vue.js & React interfaces', 'Frontend work with Vue.js and React for responsive web applications.', 'Build and maintain frontend experiences alongside API-backed web applications.'],
        ];

        foreach ($services as $index => [$icon, $title, $shortDescription, $description]) {
            Service::firstOrCreate(['title' => $title], [
                'icon' => $icon,
                'title' => $title,
                'short_description' => $shortDescription,
                'description' => $description,
                'sort_order' => $index,
                'is_active' => true,
            ]);
        }

        $projects = [
            [
                'title' => 'Laravel B2B E-commerce — PC Exporters',
                'slug' => 'laravel-b2b-ecommerce-website',
                'type' => 'Laravel / B2B E-commerce',
                'summary' => 'One of 7+ Laravel websites I have worked on: B2B e-commerce development for PC Exporters.',
                'problem' => 'PC Exporters needed a B2B e-commerce website built around its requirements.',
                'solution' => 'Developed the client’s B2B e-commerce website with Laravel.',
                'description' => 'This project is one of 7+ Laravel websites I have worked on. It is a B2B e-commerce website for PC Exporters, customized around the client’s requirements.',
                'responsibilities' => "Laravel website development\nB2B e-commerce implementation\nCustomizing the project to client requirements",
                'tech_stack' => 'Laravel, PHP, MySQL',
                'project_url' => 'https://pcexporters.com',
                'image' => 'images/project-1.svg',
                'is_featured' => true,
            ],
            [
                'title' => 'WordPress Winery Websites',
                'slug' => 'wordpress-winery-websites',
                'type' => 'WordPress / Winery websites',
                'summary' => 'WordPress work across 10+ winery websites, including Lewis & Clark Winery and Lake Creek Winery.',
                'problem' => 'Winery clients needed websites customized to their individual requirements.',
                'solution' => 'Worked on and customized more than 10 winery websites using WordPress.',
                'description' => 'A collection of WordPress winery website projects. Selected client sites include Lewis & Clark Winery (lewisandclarkwinery.com) and Lake Creek Winery (lakecreekwinery.com).',
                'responsibilities' => "WordPress website development and customization\nImplementing client-requested website changes\nWork across 10+ winery websites",
                'tech_stack' => 'WordPress, PHP',
                'project_url' => 'https://lewisandclarkwinery.com',
                'image' => 'images/project-2.svg',
                'is_featured' => true,
            ],
            [
                'title' => 'Mobile APIs for 30+ Apps',
                'slug' => 'mobile-apis-for-30-plus-apps',
                'type' => 'Laravel / Mobile APIs',
                'summary' => 'Laravel API development supporting more than 30 mobile applications.',
                'problem' => 'Multiple mobile applications needed backend APIs to connect them with their services.',
                'solution' => 'Developed mobile APIs with Laravel for use across 30+ apps.',
                'description' => 'Laravel backend API work for more than 30 mobile apps.',
                'responsibilities' => "Laravel API development\nBackend support for mobile applications",
                'tech_stack' => 'Laravel, PHP, REST APIs',
                'image' => 'images/project-3.svg',
                'is_featured' => true,
            ],
            [
                'title' => 'Tutor LMS Quiz Platform',
                'slug' => 'tutor-lms-quiz-platform',
                'type' => 'WordPress / E-learning',
                'summary' => 'A WordPress quiz setup customized with Tutor LMS to meet client requirements.',
                'problem' => 'The client needed a quiz experience configured for its specific requirements.',
                'solution' => 'Set up quizzes using Tutor LMS and customized the WordPress experience for the client.',
                'description' => 'A client WordPress project using Tutor LMS for quiz setup and customization.',
                'responsibilities' => "Tutor LMS quiz setup\nWordPress customization\nAdapting the experience to client requirements",
                'tech_stack' => 'WordPress, Tutor LMS, PHP',
                'image' => 'images/project-4.svg',
                'is_featured' => false,
            ],
            [
                'title' => 'Node.js Chat & Video Calling',
                'slug' => 'nodejs-chat-video-calling',
                'type' => 'Node.js / Real-time',
                'summary' => 'Socket-based real-time chat and video-call features built with Node.js.',
                'problem' => 'The product required interactive, real-time communication features.',
                'solution' => 'Worked on socket-based chat and video-call functionality using Node.js.',
                'description' => 'Node.js real-time development covering socket-based chat and video-call features.',
                'responsibilities' => "Node.js development\nSocket-based chat features\nVideo-call functionality",
                'tech_stack' => 'Node.js, Sockets, JavaScript',
                'image' => 'images/project-5.svg',
                'is_featured' => false,
            ],
            [
                'title' => 'Milk Club WordPress Website',
                'slug' => 'milk-club-wordpress-website',
                'type' => 'WordPress / Client website',
                'summary' => 'WordPress website work for Milk Club.',
                'problem' => 'The project needed a WordPress website that could be adapted to the client’s requirements.',
                'solution' => 'Worked on the Milk Club website using WordPress.',
                'description' => 'A WordPress website project for Milk Club.',
                'responsibilities' => "WordPress website development\nClient website updates and customization",
                'tech_stack' => 'WordPress, PHP',
                'project_url' => 'https://milkclub.com',
                'image' => 'images/project-6.svg',
                'is_featured' => false,
            ],
            [
                'title' => 'Motion Tyre WordPress Website',
                'slug' => 'motion-tyre-wordpress-website',
                'type' => 'WordPress / Client website',
                'summary' => 'WordPress website work for Motion Tyre.',
                'problem' => 'The project needed a WordPress website that could be adapted to the client’s requirements.',
                'solution' => 'Worked on the Motion Tyre website using WordPress.',
                'description' => 'A WordPress website project for Motion Tyre.',
                'responsibilities' => "WordPress website development\nClient website updates and customization",
                'tech_stack' => 'WordPress, PHP',
                'project_url' => 'https://motiontyre.com',
                'image' => 'images/project-7.svg',
                'is_featured' => false,
            ],
        ];

        foreach ($projects as $index => $project) {
            $project += [
                'project_url' => null,
                'screenshots' => null,
                'seo_title' => $project['title'].' | Project Portfolio',
                'seo_description' => $project['summary'],
                'is_published' => true,
                'is_demo' => false,
                'sort_order' => $index,
            ];
            Project::firstOrCreate(['slug' => $project['slug']], $project);
        }

        $integrations = [
            ['Laravel', 'Backend development', 'Web applications, B2B e-commerce and APIs built with Laravel.', 'LAR'],
            ['WordPress', 'CMS & e-learning', 'Client websites, winery projects and Tutor LMS quiz customization.', 'WP'],
            ['Node.js', 'Real-time development', 'Socket-based chat and video-call features.', 'JS'],
        ];

        foreach ($integrations as $index => [$name, $category, $description, $icon]) {
            Integration::firstOrCreate(['name' => $name], [
                'name' => $name,
                'category' => $category,
                'description' => $description,
                'icon' => $icon,
                'sort_order' => $index,
                'is_active' => true,
            ]);
        }

        // Do not seed fictional employers, employment history, or client testimonials.

        $settings = [
            'site_name' => 'Vijay Thakur',
            'seo_title' => 'Vijay Thakur | Full-Stack Developer',
            'seo_description' => 'Full-stack developer with 4.5 years of experience, 7+ Laravel websites, mobile APIs, Node.js, frontend frameworks and WordPress.',
            'cta_title' => 'Have a web, API or real-time project in mind?',
            'cta_text' => 'Share the requirements, current challenges and expected outcome. We can discuss a practical implementation plan.',
            'footer_text' => 'Full-stack development with Laravel, PHP, Node.js, frontend frameworks and WordPress.',
            'accent_label' => 'Laravel · PHP · Node.js · Vue.js · React · WordPress',
        ];

        foreach ($settings as $key => $value) {
            Setting::firstOrCreate(['key' => $key], ['value' => $value]);
        }
    }
}
