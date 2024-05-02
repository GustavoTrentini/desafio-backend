<?php

namespace App\Jobs;

use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public NotificationService $notificationService;
    public int $payee;
    /**
     * Create a new job instance.
     */
    public function __construct(int $payee)
    {
        $this->payee = $payee;
        $this->notificationService = new NotificationService();
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $payee = User::find($this->payee);

        if($payee){
            $this->notificationService->sendEmail($payee);

            if($payee->phone){
                $this->notificationService->sendSms($payee);
            }
        }
    }
}
