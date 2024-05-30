<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ScanReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $scan;
    public $labType;
    public $dueDate;

    /**
     * Create a new message instance.
     */
    public function __construct($scan, $labType, $dueDate)
    {
        $this->scan = $scan;
        $this->labType = $labType;
        $this->dueDate = $dueDate;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Scan Reminder for ' . $this->scan->id,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.scan_reminder',
            with: [
                'scan' => $this->scan,
                'labType' => $this->labType,
                'dueDate' => $this->dueDate,
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
