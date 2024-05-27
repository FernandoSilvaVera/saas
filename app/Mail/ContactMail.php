<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public $messageUser;
    public $userEmail;

    /**
     * Create a new message instance.
     */
    public function __construct($messageUser, $userEmail)
    {
	    $this->messageUser = $messageUser;
	    $this->userEmail = $userEmail;
    }

    public function build()
    {
	    return $this->subject('Nuevo mensaje de un usuario')
		    ->view('emails.contact')
		    ->with([
			    'messageUser' => $this->messageUser,
			    'userEmail' => $this->userEmail,
	    ]);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nuevo mensaje de un usuario',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.contact',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
