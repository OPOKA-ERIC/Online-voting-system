<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $testimonials = [
            [
                'quote'    => '"VoteSecure transformed our student guild elections. Results were instant, transparent, and no one questioned the outcome for the first time in years."',
                'name'     => 'Dr. Sarah Omondi',
                'role'     => 'Dean of Students, Nairobi University',
                'initials' => 'SO',
                'gradient' => 'from-indigo-400 to-violet-500',
                'rating'   => 5,
            ],
            [
                'quote'    => '"We ran our AGM vote for 3,000 members across 12 countries. Zero technical issues, 94% turnout. Absolutely remarkable platform."',
                'name'     => 'James Kariuki',
                'role'     => 'CEO, East Africa Trade Union',
                'initials' => 'JK',
                'gradient' => 'from-amber-400 to-orange-500',
                'rating'   => 5,
            ],
            [
                'quote'    => '"The audit trail gave our board complete confidence. Every vote was verifiable and the security report was spotless."',
                'name'     => 'Amina Hassan',
                'role'     => 'Compliance Director, FinCorp Kenya',
                'initials' => 'AH',
                'gradient' => 'from-cyan-400 to-emerald-500',
                'rating'   => 5,
            ],
        ];

        foreach ($testimonials as $t) {
            Testimonial::firstOrCreate(['name' => $t['name']], $t);
        }
    }
}
