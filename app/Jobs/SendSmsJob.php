<?php
namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendSmsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $phone;
    protected $otp;

    public function __construct($phone, $otp)
    {
        $this->phone = $phone;
        $this->otp   = $otp;
    }

    public function handle()
    {
        $key             = "QgR0kyTsNbOWkDU1";
        $mbl             = $this->phone;
        $message_content = urlencode("From LaVenjal - Welcome to BHUVIJ NOURISHMENTS PRIVATE LIMITED. Please use this OTP : " . $this->otp . " to continue login. Do Not share your OTP with anyone. BHUVIJ");
        $senderid        = "BHUVIJ";
        $templateid      = "1707168838968916653";
        $url             = "https://sms.textspeed.in/vb/apikey.php?apikey=$key&senderid=$senderid&templateid=$templateid&number=$mbl&message=$message_content";

        // Use cURL with a timeout to prevent hanging
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15); // max 15 seconds
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5); // connect timeout 5 seconds
        curl_exec($ch);
        curl_close($ch);
    }
}
