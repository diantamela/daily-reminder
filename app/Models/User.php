<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relationships
    public function userReminders()
    {
        return $this->hasMany(UserReminder::class);
    }

    public function reflections()
    {
        return $this->hasMany(Reflection::class);
    }

    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }

    public function hasRole($role)
    {
        // For a simple implementation, we can check if the user's email is in a list of admin emails
        // In a production app, you would implement proper role management
        $adminEmails = ['admin@example.com']; // This would be configurable in a real app

        // For this implementation, let's just check if the user's email ends with @admin.com
        return str_ends_with($this->email, '@admin.com') || $this->email === 'admin@example.com';
    }
}
