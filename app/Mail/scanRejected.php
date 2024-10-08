<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ScanRejected extends Mailable
{
    use Queueable, SerializesModels;

    public $content;
    protected $fromEmail;
    protected $fromName;

    /**
     * Create a new message instance.
     */
    public function __construct($content, $fromEmail = null, $fromName = null)
    {
        $this->content = $content;
        $this->fromEmail = $fromEmail;
        $this->fromName = $fromName;
    }

    public function envelope(): Envelope
    {
        $envelope = new Envelope(subject: 'Scan Rejected');

        if ($this->fromEmail) {
            $envelope->from($this->fromEmail, $this->fromName);
        }

        return $envelope;
    }

    public function content(): Content
    {
        return new Content(view: 'mail.scan-rejected');
    }

}
