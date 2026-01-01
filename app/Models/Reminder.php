<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    use HasFactory;

    protected $fillable = [
        'message',
        'category',
        'scheduled_date',
        'is_active',
    ];

    protected $casts = [
        'scheduled_date' => 'date',
        'is_active' => 'boolean',
    ];

    // Relationships
    public function userReminders()
    {
        return $this->hasMany(UserReminder::class);
    }

    public function reflections()
    {
        return $this->hasMany(Reflection::class);
    }

    // Scope to get active reminders
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}