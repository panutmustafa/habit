<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Reflection;
use App\Models\User;

class ReflectionReviewed extends Notification
{
    use Queueable;

    public $reflection;
    public $teacher;

    /**
     * Create a new notification instance.
     */
    public function __construct(Reflection $reflection, User $teacher)
    {
        $this->reflection = $reflection;
        $this->teacher = $teacher;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'reflection_id' => $this->reflection->id,
            'reflection_content_snippet' => \Illuminate\Support\Str::limit($this->reflection->content, 50),
            'teacher_name' => $this->teacher->name,
            'message' => "Guru {$this->teacher->name} telah meninjau refleksi mingguan Anda untuk minggu ke " . \Carbon\Carbon::parse($this->reflection->week_start_date)->format('d M Y') . ".",
            'url' => route('siswa.dashboard'), // Student can go to dashboard to see their reflections
        ];
    }
}
