<?php

namespace App\Mail;

use App\Models\TreatmentPlan;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TreatmentPlanReady extends Mailable
{
    use Queueable, SerializesModels;

    public $plan;

    public function __construct(TreatmentPlan $plan)
    {
        $this->plan = $plan;
    }

    public function envelope(): \Illuminate\Mail\Mailables\Envelope
    {
        return new \Illuminate\Mail\Mailables\Envelope(
            subject: 'Treatment Plan Ready for Scan #' . $this->plan->scan_id,
        );
    }

    public function content(): \Illuminate\Mail\Mailables\Content
    {
        return new \Illuminate\Mail\Mailables\Content(
            view: 'Mail.treatment_plan_ready',
            with: [
                'plan' => $this->plan,
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
