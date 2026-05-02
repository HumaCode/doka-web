<?php

namespace App\Mail\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

use Illuminate\Support\Facades\URL;

class NewUserRegistrationNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $loginUrl;

    /**
     * Create a new message instance.
     */
    public function __construct($user)
    {
        $this->user = $user;
        
        // Generate a temporary signed URL valid for 60 minutes
        $this->loginUrl = URL::temporarySignedRoute(
            'admin.quick-login',
            now()->addMinutes(60),
            ['user' => $user->id]
        );
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🔔 Pendaftaran Akun Baru: ' . $this->user->name,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.admin.new-user-registration',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
