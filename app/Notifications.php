<?php

namespace App\Notifications;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class TaskNotification extends Notification
{
    use Queueable;

    protected $task;
    protected $notificationType;

    public function __construct(Task $task, string $notificationType)
    {
        $this->task = $task;
        $this->notificationType = $notificationType;
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $mailMessage = (new MailMessage());

        switch ($this->notificationType) {
            case 'assigned':
                $mailMessage
                    ->subject('New Task Assigned')
                    ->line('A new task has been assigned to you.')
                    ->line("Task Title: {$this->task->title}")
                    ->line("Description: {$this->task->description}")
                    ->action('View Task', url("/tasks/{$this->task->id}"));
                break;

            case 'status_updated':
                $mailMessage
                    ->subject('Task Status Updated')
                    ->line('The status of a task has been updated.')
                    ->line("Task Title: {$this->task->title}")
                    ->line("New Status: {$this->task->status}")
                    ->action('View Task', url("/tasks/{$this->task->id}"));
                break;

            case 'due_soon':
                $mailMessage
                    ->subject('Task Due Soon')
                    ->line('A task is approaching its due date.')
                    ->line("Task Title: {$this->task->title}")
                    ->line("Due Date: {$this->task->due_date}")
                    ->action('View Task', url("/tasks/{$this->task->id}"));
                break;
        }

        return $mailMessage;
    }

    public function toArray(object $notifiable): array
    {
        return [
            'task_id' => $this->task->id,
            'title' => $this->task->title,
            'type' => $this->notificationType,
        ];
    }
}
