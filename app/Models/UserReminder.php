<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserReminder extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'reminder_id',
        'viewed_at',
        'marked_as_read',
    ];

    protected $casts = [
        'viewed_at' => 'datetime',
        'marked_as_read' => 'boolean',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reminder()
    {
        return $this->belongsTo(Reminder::class);
    }
}