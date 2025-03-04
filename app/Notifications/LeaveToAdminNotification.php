<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Employee;

class LeaveToAdminNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $data;


    public function __construct($insert)
    {
       $this->data = $insert;
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

    public function toArray(object $notifiable): array
    {
        $employe = Employee::where('id',$this->data->emp_id)->first();
        return [
            'leave_id' => $this->data['id'], 
            'emp_name' => $employe->emp_name, 
        ];
    }
}
