<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Reflection;
use App\Models\User;
use Carbon\Carbon;

class ReflectionSubmitted extends Notification
{
    use Queueable;

    public $reflection;
    public $student;

    /**
     * Create a new notification instance.
     */
    public function __construct(Reflection $reflection, User $student)
    {
        $this->reflection = $reflection;
        $this->student = $student;
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
            'student_name' => $this->student->name,
            'message' => "Siswa {$this->student->name} telah menyerahkan refleksi mingguan untuk minggu ke " . Carbon::parse($this->reflection->week_start_date)->format('d M Y') . ".",
            'url' => route('guru.students.reflections', $this->student), // Teacher can go to student's reflections page
        ];
    }
}
