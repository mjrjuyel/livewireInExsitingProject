<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Leave;

class LeaveToEmployeNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $data;
    public function __construct($alldata)
    {
        $this->data = $alldata;
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
        $allData = Leave::where('id',$this->data->id)->first();
        return [
            'leave_id' => $allData->id,
            'emp_id'=>$allData->emp_id,
            'updated_at' => $allData->updated_at,
        ];
    }
}
