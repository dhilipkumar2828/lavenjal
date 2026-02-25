<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Feedback;
use App\Models\User;
use Mail;
use Session;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
  

    public function index($type)
    {
        $feedbacks=Feedback::where('type',$type)->get();
       return view('backend.feedback.index',['feedbacks'=>$feedbacks,'type'=>$type]);
       
    }

    public function view()
    {

       return view('backend.coupon.add');
    }

public function send_mail(Request $request,$id){
    $validate=$request->validate([
        'feedback_response'=>'required',
        ],
        [
         'feedback_response.required'=>"This field is required",
        ]
        );
        
        $user=User::find($request->email);
              $data = array('response'=>$request->feedback_response);
      Mail::send('mail.feedback', $data, function($message) use($user) {
         $message->to($user->email, $user->name)->subject
            ('Feedback response');
         $message->from('no-reply@lavenjal.com','Lavenjal');
      });
      
        $feedback=Feedback::find($id);
        $feedback->update($validate);
        Session::flash('success','Mail sent Sucessfully');
        return redirect('feedback');
        
}
    // public function delivery()
    // {

    //    return delivery('backend.orders.view_delivery');
    // }
    
}
