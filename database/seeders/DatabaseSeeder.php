<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Interview;
use App\Models\Question;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create test users
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@test.com',
            'password' => Hash::make('password123'),
            'role' => 'admin'
        ]);

        $reviewer = User::create([
            'name' => 'Reviewer User',
            'email' => 'reviewer@test.com',
            'password' => Hash::make('password123'),
            'role' => 'reviewer'
        ]);

        $candidate = User::create([
            'name' => 'Candidate User',
            'email' => 'candidate@test.com',
            'password' => Hash::make('password123'),
            'role' => 'candidate'
        ]);

        // Create sample interview
        $interview = Interview::create([
            'title' => 'Software Developer Position',
            'description' => 'Interview for Senior Software Developer role focusing on technical skills and problem-solving abilities.',
            'created_by' => $admin->id
        ]);

        // Add questions
        $questions = [
            'Tell us about yourself and your experience.',
            'What is your greatest strength as a developer?',
            'Describe a challenging project you worked on.',
            'Where do you see yourself in 5 years?',
            'Why do you want to work with our company?'
        ];

        foreach ($questions as $index => $questionText) {
            Question::create([
                'interview_id' => $interview->id,
                'question_text' => $questionText,
                'order' => $index + 1
            ]);
        }
    }
}