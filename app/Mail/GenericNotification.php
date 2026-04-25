<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GenericNotification extends Mailable
{
    use Queueable, SerializesModels;

    public string $notif_title;
    public string $notif_body;
    public ?string $notif_link;
    public string $recipient_name;

    public function __construct(string $title, string $body, ?string $link = null, string $recipientName = '')
    {
        $this->notif_title    = $title;
        $this->notif_body     = $body;
        $this->notif_link     = $link;
        $this->recipient_name = $recipientName;
    }

    public function build()
    {
        return $this->subject($this->notif_title)
            ->view('email.notification_template')
            ->with([
                'notif_title'    => $this->notif_title,
                'notif_body'     => $this->notif_body,
                'notif_link'     => $this->notif_link,
                'recipient_name' => $this->recipient_name,
            ]);
    }
}
