<?php

namespace App\Mail;

use App\Models\Invite;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class InviteCreated extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * The invite instance.
     *
     * @var \App\Models\Invite
     */
    public Invite $invite;

    /**
     * Create a new message instance.
     */
    public function __construct(Invite $invite)
    {
        $this->invite = $invite;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('info@firstlovechurch.com', 'First Love'),
            replyTo: [
                new Address('mills@yahoo.com', 'J. Mills'),
            ],
            subject: 'You\'re Invited to Join First Love Church',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.invite',
            with: [
                'invite' => $this->invite,
                'url' => route('invite.accept', ['token' => $this->invite->token]),
            ],
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