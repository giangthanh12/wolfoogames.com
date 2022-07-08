<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use App\Mail\MailNotify;
use App\Models\Config;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $message;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($message)
    {
        $this->message = $message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
            // Mail::to("giangnt1@s-connect.net")->send(new MailNotify($this->message));

            $data = (array) $this->message->toArray();
            $emails_config = Config::get_emails();
            Mail::send('mails.feedback', $data , function($message) use ($emails_config)
            {
                $message->to($emails_config)->subject('This is test e-mail');
            });


    }
}
