<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentHabit extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'habit_id',
        'date',
        'is_completed',
    ];

    /**
     * Get the user that owns the student habit.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the habit that owns the student habit.
     */
    public function habit(): BelongsTo
    {
        return $this->belongsTo(Habit::class);
    }
}
