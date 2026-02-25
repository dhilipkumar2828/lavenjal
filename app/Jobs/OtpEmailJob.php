<?php
namespace App\Jobs;

use App\Mail\OtpMail;

use Illuminate\Bus\Queueable;

use Illuminate\Contracts\Queue\ShouldBeUnique;

use Illuminate\Contracts\Queue\ShouldQueue;

use Illuminate\Foundation\Bus\Dispatchable;

use Illuminate\Queue\InteractsWithQueue;

use Illuminate\Queue\SerializesModels;
use Throwable;
use Mail;
class OtpEmailJob implements ShouldQueue

{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $details;

    /**

     * Create a new job instance.

     *

     * @return void

     */

    public function __construct($details)

    {
        $this->details = $details;

    }



    /**

     * Execute the job.

     *

     * @return void

     */

    public function handle()

    {

        $email = new OtpMail($this->details);
       
        try{
            Mail::to($this->details['email'])->send($email);  
        }catch(Throwable $exception){
            $success['statuscode'] =401;
            $success['message']="sorry we don't recognize this email";
            $params=[];
            $success['params']=$params;
            $response['response']=$success;
            return \Response::json($response, 401);
         }
        // if( Mail::to($this->details['email'])->send($email)){
        //     return true;
        // }else{
        //     return false;
        // }
    }

}

