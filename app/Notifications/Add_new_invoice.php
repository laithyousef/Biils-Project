<?php

namespace App\Notifications;

use App\Models\Invoices;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class Add_new_invoice extends Notification
{
    use Queueable;
    public $id ;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($id)
    {
        $this->$id = $id;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        $id = Invoices::latest()->first()->id;
        return [
            
               'id'     => $this->$id ,
               'title'  => 'تم إضافة فاتورة جديدة بواسطة',
               'user'   => Auth::user()->name,

        ];
    }

}
