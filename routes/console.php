<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;

Artisan::command('marketlink:test-mail {email}', function (string $email) {
    $this->info('Sending test email to ' . $email . ' ...');

    try {
        Mail::raw(
            "MarketLink SMTP test\n\nIf you received this email, customer password-reset emails can be delivered through the configured mail server.",
            function ($message) use ($email) {
                $message->to($email)->subject('MarketLink SMTP test');
            }
        );

        $this->info('Test email accepted by the configured mail transport.');
        $this->comment('Check the recipient Inbox and Spam folders.');
        return self::SUCCESS;
    } catch (Throwable $e) {
        $this->error('Mail test failed: ' . $e->getMessage());
        return self::FAILURE;
    }
});
