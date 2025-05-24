<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class IncomingBookNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $bookData;
    protected $attachmentPath;

    public function __construct($bookData, $attachmentPath = null)
    {
        $this->bookData = $bookData;
        $this->attachmentPath = $attachmentPath;
    }

    public function build()
    {
        $mail = $this->subject($this->bookData['subject'] . ' - ' . $this->bookData['book_number'])
                    ->markdown('emails.incomingbook-notification');
        
        if ($this->attachmentPath && file_exists($this->attachmentPath)) {
            $mail->attach($this->attachmentPath);
        }

        return $mail;
    }
}
