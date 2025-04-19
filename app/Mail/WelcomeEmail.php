<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $messageContent;
    public $subjectLine;

    public function __construct($messageContent, $subjectLine)
    {
        $this->messageContent = $messageContent;
        $this->subjectLine = $subjectLine;
    }

    public function build()
    {
        return $this->subject($this->subjectLine)
                    ->view('mail.medication_reminder');
    }
}
