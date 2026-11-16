<?php
namespace App\Services;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
class MarketLinkMailService {
    public static function send(?string $to,string $subject,string $body): bool {
        if (!$to || !filter_var($to,FILTER_VALIDATE_EMAIL)) return false;
        if (config('mail.default') === 'log') return false;
        try { Mail::raw($body, function($m) use($to,$subject){$m->to($to)->subject($subject);}); return true; }
        catch(\Throwable $e){ Log::warning('MarketLink mail failed',['to'=>$to,'subject'=>$subject,'error'=>$e->getMessage()]); return false; }
    }
}
