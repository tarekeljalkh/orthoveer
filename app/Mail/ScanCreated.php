<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ScanCreated extends Mailable
{
    public $content;
    protected $fromEmail;
    protected $fromName;

    public function __construct($content, $fromEmail = null, $fromName = null)
    {
        $this->content = $content;
        $this->fromEmail = $fromEmail;
        $this->fromName = $fromName;
    }

    public function envelope(): Envelope
    {
        $envelope = new Envelope(subject: 'Case Submission Confirmation for: ' . $this->content['patientName']);

        if ($this->fromEmail) {
            $envelope->from($this->fromEmail, $this->fromName);
        }

        return $envelope;
    }

    public function content(): Content
    {
        return new Content(view: 'mail.scan-created');
    }
}
