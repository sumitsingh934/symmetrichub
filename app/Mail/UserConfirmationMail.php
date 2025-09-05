<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;
     
    public $user;
    /**
     * Create a new message instance.
     */
    public function __construct($user)
    {
        //
        $this->user = $user;
    }


    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Contact Confirmation Mail',
        );
    }

     public function build()
    {
        return $this->subject('We received your message!')
                    ->view('emails.contact-confirmation');
    }
  
    public function content(): Content
    {
        return new Content(
            view: 'emails.contact-confirmation',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, 
     */
    public function attachments(): array
    {
        return [];
    }
}
