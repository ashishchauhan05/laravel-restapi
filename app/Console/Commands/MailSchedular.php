<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\Mailers\Mailer;
use App\Models\MailBox;

class MailSchedular extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:schedular';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Email Schedular to send all queue emails';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $mailbox = MailBox::where('status', '=', MailBox::STATUS_PENDING)->first();
        
        if (!$mailbox) {
            echo 'no pending mail found';
            return false;
        }

        $data['message'] = $mailbox->mail_text;
        $data['id'] = $mailbox->id;
        
        $mailer = new Mailer;
        $resp = $mailer->emailTo($mailbox->type, $mailbox->mail_to, $mailbox->layout, $data, $mailbox->subject);
        
        return $resp;
    }
}
