<?php

namespace Database\Seeders;

use App\Models\SiteFaq;
use App\Models\SitePage;
use Illuminate\Database\Seeder;

class WebsiteContentSeeder extends Seeder
{
    /**
     * Seed default page content for the public website.
     */
    public function run(): void
    {
        // Default page sections
        $pages = [
            [
                'slug' => 'hero',
                'title' => 'Welcome to BGBR Rwanda',
                'content' => 'Sure & Steadfast. Empowering youth through Christian values, leadership development, and discipline for a brighter future.',
                'sort_order' => 1,
            ],
            [
                'slug' => 'mission',
                'title' => 'Our Mission',
                'content' => 'To advance the Kingdom of God among young people by providing opportunities for growth in Christian character, leadership skills, and community service through the Boys\' and Girls\' Brigade movement in Rwanda.',
                'sort_order' => 2,
            ],
            [
                'slug' => 'vision',
                'title' => 'Our Vision',
                'content' => 'A generation of young Rwandans who are sure and steadfast in their faith, confident in their leadership abilities, and committed to making a positive impact in their communities and nation.',
                'sort_order' => 3,
            ],
            [
                'slug' => 'about',
                'title' => 'About BGBR Rwanda',
                'content' => 'The Boys\' and Girls\' Brigade Rwanda is a Christian youth organisation dedicated to developing young people spiritually, physically, and socially. Through structured programs, mentorship, and community activities, we help youth become responsible, faithful, and competent leaders.',
                'sort_order' => 4,
            ],
            [
                'slug' => 'history',
                'title' => 'Our History',
                'content' => 'The Boys\' and Girls\' Brigade has a rich history of serving youth worldwide. In Rwanda, the Brigade has been a transformative force, providing structured programs that help young people develop their faith, build character, and learn valuable life skills. Through dedicated leaders and committed communities, we continue to grow and make a lasting impact on the lives of Rwandan youth.',
                'sort_order' => 5,
            ],
            [
                'slug' => 'core-values',
                'title' => 'Core Values',
                'content' => 'Faith, Discipline, Service, Leadership, Unity, Steadfastness',
                'sort_order' => 6,
            ],
            [
                'slug' => 'contact-info',
                'title' => 'Contact Information',
                'content' => 'The Boys\' and Girls\' Brigade Rwanda headquarters, Kigali, Rwanda.',
                'sort_order' => 7,
            ],
        ];

        foreach ($pages as $page) {
            SitePage::firstOrCreate(['slug' => $page['slug']], $page);
        }

        // Default FAQs
        $faqs = [
            [
                'question' => 'What is the Boys\' and Girls\' Brigade?',
                'answer' => 'The Boys\' and Girls\' Brigade is an international Christian youth organisation that provides activities and programs for children and young people. In Rwanda, we focus on developing faith, leadership, and life skills in a supportive community.',
                'category' => 'General',
                'sort_order' => 1,
            ],
            [
                'question' => 'How can I join BGBR Rwanda?',
                'answer' => 'You can join by contacting your nearest BGBR company or reaching out to us through the contact form on our website. We welcome all young people who are interested in growing in faith and leadership.',
                'category' => 'Membership',
                'sort_order' => 2,
            ],
            [
                'question' => 'What age groups does BGBR serve?',
                'answer' => 'BGBR serves children and young people of various age groups, from juniors to seniors. Each age group has programs tailored to their developmental needs and interests.',
                'category' => 'General',
                'sort_order' => 3,
            ],
            [
                'question' => 'How can I support BGBR Rwanda?',
                'answer' => 'You can support us through volunteering, donations, prayer, and spreading the word about our mission. Contact us to learn more about how you can contribute to empowering the next generation of leaders.',
                'category' => 'Support',
                'sort_order' => 4,
            ],
            [
                'question' => 'What activities does BGBR offer?',
                'answer' => 'We offer a wide range of activities including Bible study, leadership training, community service projects, sports, camping, skills development workshops, and cultural activities. Our programs are designed to develop the whole person.',
                'category' => 'General',
                'sort_order' => 5,
            ],
        ];

        foreach ($faqs as $faq) {
            SiteFaq::firstOrCreate(['question' => $faq['question']], $faq);
        }
    }
}
