<?php

namespace App\Http\Controllers;

use App\Models\Reminder;
use App\Models\UserReminder;
use App\Models\Reflection;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        // Check if user is admin - redirect them away from home page
        if (Auth::check() && Auth::user()->hasRole('admin')) {
            return redirect()->route('admin.dashboard')->with('info', 'Admins should use the Admin Dashboard to manage reminders.');
        }
        
        $today = now()->toDateString();
        
        // Try to get today's scheduled reminder first
        $reminder = Reminder::where('scheduled_date', $today)
                          ->where('is_active', true)
                          ->first();
        
        // If no scheduled reminder for today, get a random active one
        if (!$reminder) {
            $randomReminders = Reminder::where('is_active', true)
                                      ->where(function($query) use ($today) {
                                          $query->whereNull('scheduled_date')
                                                ->orWhere('scheduled_date', '!=', $today);
                                      })
                                      ->inRandomOrder()
                                      ->limit(1)
                                      ->get();
            
            $reminder = $randomReminders->first();
        }
        
        $userReminder = null;
        $reflection = null;
        $hasRead = false;
        $userReflection = null;
        
        if (Auth::check()) {
            if ($reminder) {
                // Record that the user viewed this reminder
                $userReminder = UserReminder::firstOrCreate([
                    'user_id' => Auth::id(),
                    'reminder_id' => $reminder->id,
                ], [
                    'viewed_at' => now(),
                ]);
                
                $hasRead = $userReminder->marked_as_read;
                
                // Get user's reflection for this reminder if exists
                $userReflection = Reflection::where('user_id', Auth::id())
                                          ->where('reminder_id', $reminder->id)
                                          ->first();
            }
            
            // Calculate user's streak and active days
            $streak = $this->calculateStreak(Auth::id());
            $activeDays = $this->calculateActiveDays(Auth::id());
        } else {
            $streak = 0;
            $activeDays = 0;
        }
        
        return view('home', compact('reminder', 'hasRead', 'userReflection', 'streak', 'activeDays'));
    }
    
    public function markAsRead(Request $request)
    {
        $request->validate([
            'reminder_id' => 'required|exists:reminders,id',
        ]);
        
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        $userReminder = UserReminder::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'reminder_id' => $request->reminder_id,
            ],
            [
                'marked_as_read' => true,
                'viewed_at' => now(),
            ]
        );
        
        // Log activity for streak calculation
        ActivityLog::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'activity_date' => now()->toDateString(),
            ],
            [
                'activity_type' => 'read',
            ]
        );
        
        return redirect()->back()->with('success', 'Reminder marked as read!');
    }
    
    public function saveReflection(Request $request)
    {
        $request->validate([
            'reminder_id' => 'required|exists:reminders,id',
            'content' => 'required|string|max:1000',
        ]);
        
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        $reflection = Reflection::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'reminder_id' => $request->reminder_id,
            ],
            [
                'content' => $request->content,
            ]
        );
        
        // Also mark as read if not already
        UserReminder::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'reminder_id' => $request->reminder_id,
            ],
            [
                'marked_as_read' => true,
                'viewed_at' => now(),
            ]
        );
        
        // Log activity for streak calculation
        ActivityLog::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'activity_date' => now()->toDateString(),
            ],
            [
                'activity_type' => 'reflect',
            ]
        );
        
        return redirect()->back()->with('success', 'Reflection saved successfully!');
    }
    
    private function calculateStreak($userId)
    {
        $today = now()->startOfDay();
        $streak = 0;
        $currentDate = $today;

        // Check consecutive days backwards
        while (true) {
            $activity = ActivityLog::where('user_id', $userId)
                                 ->where('activity_date', $currentDate->toDateString())
                                 ->exists();

            if ($activity) {
                $streak++;
                $currentDate = $currentDate->subDay();
            } else {
                // If we're at today and there's no activity, we need to check previous days
                // but not include today in the streak
                if ($currentDate->toDateString() === now()->toDateString()) {
                    // If no activity today, don't include today in the streak
                    break;
                } else {
                    // If we're not at today and no activity, streak is broken
                    break;
                }
            }

            // Prevent infinite loops by limiting to a reasonable range
            if ($streak > 365) {
                break;
            }
        }

        return $streak;
    }
    
    private function calculateActiveDays($userId)
    {
        return ActivityLog::where('user_id', $userId)->count();
    }
}