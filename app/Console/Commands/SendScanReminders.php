<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Models\Scan;
use App\Models\TypeOfWork;
use App\Mail\ScanReminderMail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class SendScanReminders extends Command
{
    protected $signature = 'scans:send-reminders';

    protected $description = 'Send email reminders for scans due in 2 days';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $today = Carbon::now();
        $scans = Scan::with(['typeOfWork', 'latestStatus'])->get();

        foreach ($scans as $scan) {
            $typeOfWork = $scan->typeOfWork;
            $latestStatus = $scan->latestStatus;

            if ($typeOfWork && $latestStatus) {
                // Check Lab Due Date
                $labDueDate = Carbon::parse($scan->due_date)->addDays($typeOfWork->lab_due_date);
                if ($today->diffInDays($labDueDate) == 2 && $latestStatus->status != 'completed') {
                    Mail::to($typeOfWork->lab->email)->send(new ScanReminderMail($scan, 'Lab', $labDueDate));
                    Log::info('Sent Lab reminder email to ' . $typeOfWork->lab->email);
                }

                // Check External Lab Due Date
                $externalLabDueDate = Carbon::parse($scan->due_date)->addDays($typeOfWork->external_lab_due_date);
                if ($today->diffInDays($externalLabDueDate) == 2 && $latestStatus->status != 'completed') {
                    Mail::to($typeOfWork->externalLab->email)->send(new ScanReminderMail($scan, 'External Lab', $externalLabDueDate));
                    Log::info('Sent External Lab reminder email to ' . $typeOfWork->externalLab->email);
                }

                // Check Second Lab Due Date
                $secondLabDueDate = Carbon::parse($scan->due_date)->addDays($typeOfWork->second_lab_due_date);
                if ($today->diffInDays($secondLabDueDate) == 2 && $latestStatus->status != 'completed') {
                    Mail::to($typeOfWork->secondLab->email)->send(new ScanReminderMail($scan, 'Second Lab', $secondLabDueDate));
                    Log::info('Sent Second Lab reminder email to ' . $typeOfWork->secondLab->email);
                }
            }
        }

        $this->info('Scan reminders sent successfully!');
    }
}
