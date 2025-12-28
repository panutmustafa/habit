<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    public const ADMIN_ROLE = 'admin';
    public const GURU_ROLE = 'guru';
    public const SISWA_ROLE = 'siswa';

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
        'role',
        'kela_id',
        'avatar',
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

    /**
     * Get the class that the user belongs to.
     */
    public function kela(): BelongsTo
    {
        return $this->belongsTo(Kela::class);
    }

    /**
     * Get the student habits for the user.
     */
    public function studentHabits(): HasMany
    {
        return $this->hasMany(StudentHabit::class);
    }

    /**
     * Get the reflections for the user.
     */
    public function reflections(): HasMany
    {
        return $this->hasMany(Reflection::class);
    }

    /**
     * Get the reflections that the user (teacher) has reviewed.
     */
    public function reviewedReflections(): HasMany
    {
        return $this->hasMany(Reflection::class, 'reviewed_by');
    }
}
