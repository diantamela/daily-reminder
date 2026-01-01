<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reminder;

class RemindersSeeder extends Seeder
{
    public function run()
    {
        $reminders = [
            [
                'message' => 'Every day is a new opportunity to grow. Embrace the challenges ahead with confidence.',
                'category' => 'motivation',
                'is_active' => true,
            ],
            [
                'message' => 'Take a moment to reflect on your achievements, no matter how small. Progress is progress.',
                'category' => 'reflection',
                'is_active' => true,
            ],
            [
                'message' => 'Self-discipline is choosing between what you want now and what you want most.',
                'category' => 'self-discipline',
                'is_active' => true,
            ],
            [
                'message' => 'Your potential is endless when you believe in yourself and take consistent action.',
                'category' => 'motivation',
                'is_active' => true,
            ],
            [
                'message' => 'What is one thing you did today that brought you closer to your goals?',
                'category' => 'reflection',
                'is_active' => true,
            ],
            [
                'message' => 'Small daily improvements are better than grand gestures that fizzle out.',
                'category' => 'self-discipline',
                'is_active' => true,
            ],
            [
                'message' => 'Success is not a destination, but a journey of continuous improvement.',
                'category' => 'motivation',
                'is_active' => true,
            ],
            [
                'message' => 'How did today\'s experiences shape your perspective? What did you learn?',
                'category' => 'reflection',
                'is_active' => true,
            ],
            [
                'message' => 'Discipline is choosing your future over your present desires.',
                'category' => 'self-discipline',
                'is_active' => true,
            ],
        ];

        foreach ($reminders as $reminder) {
            Reminder::create($reminder);
        }
    }
}