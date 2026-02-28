<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Exception;
use App\Models\User_address;
use App\Models\Notifications;
use App\Models\Owner_meta_data;
use App\Models\City;
use App\Models\DeliveryCharges;
use App\Models\Pincode;
use App\Models\NeededServiceList;
use Illuminate\Support\Str;
use App\helpers\Helper;
class AuthController extends Controller
{
    //
    /**
     * @OA\Post(
     ** path="/v1/user-login",
     *   tags={"Login"},
     *   summary="Login",
     *   operationId="login",
     *
     *   @OA\Parameter(
     *      name="email",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="password",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="string"
     *      )
     *   ),
     *   @OA\Response(
     *      response=200,
     *       description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *   @OA\Response(
     *      response=401,
     *       description="Unauthenticated"
     *   ),
     *   @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     *   @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *)
     **/
    /**
     * login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        try{
        $validator = $request->validate([
            'email' => 'email|required',
            'password' => 'required',
            'user_type' =>'required'
        ]);


        if (!auth()->attempt($validator)) {
            $success['statuscode'] =401;
            $success['message']="Invalid user";
            $params=[];
            $success['params']=$params;
            $response['response']=$success;
            return response()->json($response, 401);
        } else {
            // $success['token'] = auth()->user()->createToken('authToken')->accessToken;
            // $success['data'] = auth()->user();
            // $success['msg'] ="Success";
            // $success['statuscode'] =Response::HTTP_ACCEPTED;
            // return response()->json(['msg' => $success])->setStatusCode(Response::HTTP_ACCEPTED);

            // $success['statuscode'] =200;
            // $success['message']="Login successfull";
            // $success['data'] = auth()->user();

            // /**
            //  * params value (user_id,otp,token)
            // **/
            // $params['email']=$request->email;
            // $params['password']=$request->password;
            // $params['user_type']=$request->user_type;
            // $params['token'] = auth()->user()->createToken('authToken')->accessToken;

            // $success['params']=$params;
            // $response['response']=$success;
            // return response()->json($response, 200);
            
            
            //
            $success['statuscode'] =200;
        $success['message']="Loggedin successfully";
       $success['token'] = auth()->user()->createToken('authToken')->accessToken;
        /**
         * params value (user_id,otp,token)
        **/
  
          $params['email']=$request->email;
          $params['password']=$request->password;
          $params['user_type']=$request->user_type;
   

        $success['params']=$params;
        $response['response']=$success;
        return response()->json($response, 200);
        }
        }
        catch(Exception $e){
        $success['statuscode'] =401;
        $success['message']="Something went wrong";
        /**
         * params value (user_id,otp,token)
        **/
          $params=[];
          $success['params']=$params;
          $response['response']=$success;
          return response()->json($response, 401);
        }
    }


    public function send_otp(Request $request){
        try{
        $mobile_exists=User::where('phone',$request->phone)->where('user_type',$request->user_type)->exists();
        $user_id= User::where('phone',$request->phone)->where('user_type',$request->user_type)->first();
        
        $status=true;
        if(!empty($user_id)){
            if($request->user_type == "delivery_agent"){
            $shop_status  = Owner_meta_data::where('user_id',$user_id->id)->where('status',1)->exists();
            if(empty($shop_status)){
                $success['statuscode'] =400;
                    $success['message']="We're on it! Your account will be ready shortly.";
                    $params=[];
                    $success['params']=$params;
                    $response['response']=$success;
                    return response()->json($response, 400);
            }
            }
         
        if($user_id->status ==0){
                $status="inactive";
                $success['statuscode'] =400;
                $success['message']="Inactive user";
                $params['user_id']=$user_id->id;
                $params['status']=$status;
                $success['params']=$params;
                $response['response']=$success;
                return response()->json($response, 400);
        }else{
            
            $status="active";
            // if($user_id->user_type==$request->user_type){
                if($mobile_exists){
                  $otp=random_int(10000, 99999);
                  if($status){

                      if($user_id->id != 333 && $user_id->id != 318){
               
                        $user=  User::where('phone',$request->phone)->where('user_type',$request->user_type)->update(['otp'=>$otp]);
                      }
                         
                    $details['otp_code']=$otp;
                    $details['email']=$user_id->email;
                    // $valid_mail= ;
                    dispatch(new \App\Jobs\OtpEmailJob($details));
                    
                $key = "QgR0kyTsNbOWkDU1";	
                $mbl=$request->phone; 	/*or $mbl="XXXXXXXXXX,XXXXXXXXXX";*/
                $message_content=urlencode("From LaVenjal - Welcome to BHUVIJ NOURISHMENTS PRIVATE LIMITED. Please use this OTP : ".$otp." to continue login. Do Not share your OTP with anyone. BHUVIJ");
                
                $senderid="BHUVIJ";	$route= 1;
                $templateid="1707168838968916653";
                $url = "https://sms.textspeed.in/vb/apikey.php?apikey=$key&senderid=$senderid&templateid=$templateid&number=$mbl&message=$message_content";
                					
                $output = file_get_contents($url);	/*default function for push any url*/


                    $success['statuscode'] =200;
                    $success['message']="Otp sent successfully";
            
                    /**
                     * params value (user_id,otp,token)
                    **/
              
                    $params['user_id']=$user_id->id;
                    $params['status']=$status;
                    $params['otp']=$otp;
            
                    $success['params']=$params;
                    $response['response']=$success;
                    return response()->json($response, 200);
                            }
                    }else{
                        $success['statuscode'] =401;
                        $success['message']="sorry we don't recognize this phone number";
                        $params=[];
                        $success['params']=$params;
                        $response['response']=$success;
                        return response()->json($response, 401);
                    }

        }
        }else{
                    $success['statuscode'] =401;
                    $success['message']="Invalid mobile number";
                    $params=[];
                    $success['params']=$params;
                    $response['response']=$success;
                    return response()->json($response, 401);
        }
        }
        catch(Exception $e){
        $success['statuscode'] =401;
        $success['message']="Something went wrong";
        /**
         * params value (user_id,otp,token)
        **/
          $params=[];
          $success['params']=$params;
          $response['response']=$success;
          return response()->json($response, 401);
        }
    }

   public function verify_otp(Request $request){
        try{
        $validator = $request->validate([
            'user_id' => 'required',
            'otp'   =>  'required',
        ]);

        $user=User::find($request->user_id);
        $owners_meta_data=Owner_meta_data::where('user_id',$request->user_id)->first();

        if(!empty($user)){
            $isuser_active=User::where('id',$user->id)->where('status','1')->first();
          if(!empty($isuser_active)){
                if ($user->otp == $request->otp) {
                    if(empty($user->device_key)){ 

                        $token_array=array($request->token);
                        
                    }else{
                        $token=array($request->token);
                        $device_key=json_decode($user->device_key);
               
                        $token_arr=array_merge($device_key,$token);

                        $token_array=array_unique($token_arr);
        
                    }
                        $result=json_encode($token_array);

                  $user->update(['device_key'=>$result]);
                 $res=  Helper::SendNotification("Welcome ".$user->name."","Successfully Logged in","login",$request->token,$request->user_id);
                   
                   $success['statuscode'] =200;
                    $success['message']="Otp verified successfully";
                    $success['token'] = $user->createToken('authToken')->accessToken;
                    /**
                     * params value (user_id,otp,token)
                    **/
              
                    $params['user_id']=$user->id;
                    $params['otp']=$user->otp;
                    $params['token']=$request->token;
                     $params['res']=$res;
                    $params['user_name']=$user->name;
                    
                    $success['params']=$params;
                    $success['user_details']=$params;
                    $response['response']=$success;
                    return response()->json($response, 200);
                } else {
                    $success['statuscode'] =401;
                    $success['message']="Invalid otp credentials";
                    $params=[];
                    $success['params']=$params;
                    $response['response']=$success;
                    return response()->json($response, 401);
                }
     

            }  else{
                        $success['statuscode'] =200;
                        $success['message']="Inactive user";
                        $params=[];
                        $success['params']=$params;
                        $response['response']=$success;
                        return response()->json($response, 200);
                }
         }else{
                    $success['statuscode'] =401;
                    $success['message']="Invalid user";
                    $params=[];
                    $success['params']=$params;
                    $response['response']=$success;
                    return response()->json($response, 401);
         }
        }
        catch(Exception $e){
        $success['statuscode'] =401;
        $success['message']="Something went wrong";
        /**
         * params value (user_id,otp,token)
        **/
          $params=[];
          $success['params']=$params;
          $response['response']=$success;
          return response()->json($response, 401);
        }
    }

    /**
     * @OA\Post(
     ** path="/v1/user-register",
     *   tags={"Register"},
     *   summary="Register",
     *   operationId="register",
     *
     *  @OA\Parameter(
     *      name="name",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="email",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Parameter(
     *       name="mobile_number",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="integer"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="password",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *      @OA\Parameter(
     *      name="password_confirmation",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Response(
     *      response=201,
     *       description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *   @OA\Response(
     *      response=401,
     *       description="Unauthenticated"
     *   ),
     *   @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     *   @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *)
     **/
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        try{
            DB::beginTransaction();
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'password' => 'nullable',
            'user_type' => 'required',
        ]);


        $duplicate=User::where('email',$request->email)->where('user_type',$request->user_type)->first();
        $duplicate_phone=User::where('phone',$request->phone)->where('user_type',$request->user_type)->first();

        if (!empty($duplicate)) {
      
            $success['statuscode'] =401;
            $success['message']="Email already exists";
            $params=[];
            $success['params']=$params;
            $response['response']=$success;
            return response()->json($response, 401);
        }
        else if(!empty($duplicate_phone)){
            
            $success['statuscode'] =401;
            $success['message']="Phone already exists";
            $params=[];
            $success['params']=$params;
            $response['response']=$success;
            return response()->json($response, 401); 
        }
        
        else{
            $input = $request->all();

           if (!empty($request->password)) {
                $input['password'] = Hash::make($request->password);
            } else {
                $input['password'] = null; // or set default value
            }
            // if($input['user_type']=='customer'){
                $input['status'] = '1';
            // }else{
            //     $input['status'] = '0';
            // }

            if($input['user_type']=='retailer'){
                $input['aadhar_number']=$request->aadhar_number;
                $file = $request->file('business_certificate');
                $file_name= $file->getClientOriginalName();
                $file->move(public_path().'/uploads/', $file_name);
                $input['business_certificate']='uploads/'.$file_name;
            }
            
                   if($input['user_type'] == "distributor" || $input['user_type'] == "delivery_agent" ){
                 $input['aadhar_number']=$request->aadhar_number;
                 $input['landmark']=$request->landmark;
                //gst certificate
                $input['gst_certificate']=$request->gst_certificate;
                    $gstfile = $request->file('gst_certificate');
                    if(!empty($gstfile)){
                    $file_name= $gstfile->getClientOriginalName();
                    $gstfile->move(public_path().'/uploads/', $file_name);
                    $input['gst_certificate']='uploads/'.$file_name;
                }
                //govt certificate
                $input['govt_certificate']=$request->govt_certificate;
                    $govtfile = $request->file('govt_certificate');     
                    if(!empty($govtfile)){
                    $file_name= $govtfile->getClientOriginalName();
                    $govtfile->move(public_path().'/uploads/', $file_name);
                    $input['govt_certificate']='uploads/'.$file_name;
                }
                
                //shop photo
                $input['shop_photo']=$request->shop_photo;
              
                    $shopfile = $request->file('shop_photo');
                    if(!empty($shopfile)){
                    $file_name= $shopfile->getClientOriginalName();
                    $shopfile->move(public_path().'/uploads/', $file_name);
                    $input['shop_photo']='uploads/'.$file_name;
                }
            }
            $user = User::create($input);
            $useraddress=json_decode($request->address);

            //User_address
            $checkuser_address=User_address::where('user_id',$user->id)->first();
            $user_address=new User_address;
            $user_address->user_id=$user->id;
            $user_address->full_name=$request->name;
            $user_address->door_no=$useraddress->door_no;
            $user_address->flat_no=(!empty($useraddress->flat_no)?$useraddress->flat_no:'');
            $user_address->floor_no=(!empty($useraddress->floor_no)?$useraddress->floor_no:'');
            $user_address->phone_number=(!empty($useraddress->phone_number)?$useraddress->phone_number:'');
            $user_address->is_lift=($useraddress->is_lift =="0" ?"false" : "true");
            $user_address->address=$useraddress->address;
            $user_address->city=$useraddress->city;
            $user_address->state=$useraddress->state;
            $user_address->zip_code=$useraddress->zip_code;
            $user_address->lat=$useraddress->lat;
            $user_address->lang=$useraddress->lang;
            $user_address->is_default="true";
            $user_address->full_address=$useraddress->door_no.' '.$useraddress->address.' '.$useraddress->city.' '.$useraddress->state.' '.$useraddress->zip_code;
            $user_address->address_type=$useraddress->address_type;
            $user_address->save();
            

            if($input['user_type'] != "customer"){
                $owner_meta_data=new Owner_meta_data;
                $owner_meta_data->user_id=$user->id;
                $owner_meta_data->user_type=$request->user_type;
                if($input['user_type'] == "retailer" || $input['user_type'] == "distributor"){
                  $owner_meta_data->name_of_shop=$request->shop_name; 
                  $owner_meta_data->full_address=$request->shop_address; 
                }
                
               if($input['user_type'] == "distributor" || $input['user_type'] == "delivery_agent" ){
                  $owner_meta_data->nature_of_shop=$request->shop_nature; 
                  $owner_meta_data->ownership_type=$request->ownership_status; 
                  $owner_meta_data->delivery_type=$request->delivery_facility; 
                  $owner_meta_data->no_of_delivery_boys=$request->no_of_delivery_persons; 
                  $owner_meta_data->gst_certificate= $input['gst_certificate']; 
                  $owner_meta_data->govt_certificate= $input['govt_certificate']; 
                  $owner_meta_data->shop_photo= $input['shop_photo']; 
                  $owner_meta_data->name_of_shop=$request->shop_name; 
                }
                $owner_meta_data->name_of_owner=$request->name;
                $owner_meta_data->owner_contact_no=$request->phone;
                $owner_meta_data->owner_email=$request->email;
                $owner_meta_data->pincode=$useraddress->zip_code;
                $owner_meta_data->full_address=$useraddress->door_no.' '.$useraddress->address.' '.$useraddress->city.' '.$useraddress->state.' '.$useraddress->zip_code;
                $owner_meta_data->lat=$useraddress->lat;
                $owner_meta_data->lang=$useraddress->lang;
                
                $owner_meta_data->save();
             }
             
            //Notifications
            $u_type=ucfirst($user->user_type);
            if($user->user_type=="customer"){

                $msg="New user has been Registered";
            }else{
                $msg="New ".$u_type." has been registered and waiting for your approval";
            }
            $notifications=new Notifications;
            $notifications->user_id=$user->id;
            $notifications->message=$msg;
            $notifications->type="register";
            $notifications->save();
            Helper::live_notification();
            $success['statuscode'] =200;
            $success['message']="Registered Succesfully";
    
            /**
             * params value (user_id,otp,token)
            **/
            $params['name']=$request->name;
            $params['email']=$request->email;
            $params['password']=$request->password;
            $params['phone']=$request->phone;
            $params['user_type']=$request->user_type;
            if($input['user_type'] == "retailer"){
             $params['aadhar_number']=$request->aadhar_number;
             $params['shop_name']=$request->shop_name;
             $params['shop_address']=$request->shop_address;
            }
            
            if($input['user_type'] == "distributor" || $input['user_type'] == "delivery_agent" ){
             $params['shop_name']=$request->shop_name;
             $params['shop_address']=$request->shop_address;
             $params['shop_nature']=$request->shop_nature;
             
             $params['ownership_status']=$request->ownership_status;
             $params['delivery_facility']=$request->delivery_facility;
             $params['no_of_delivery_persons']=$request->no_of_delivery_persons;
             $params['gst_certificate']=$input['gst_certificate'];
             $params['govt_certificate']=$input['govt_certificate'];
             $params['shop_photo']=$input['shop_photo'];
             $params['aadhar_number']=$input['aadhar_number'];
             $params['landmark']=$input['landmark'];
            }

            $address['full_name']=$request->name;
            $address['door_no']=$useraddress->door_no;
            $address['is_lift']=$useraddress->is_lift;
            $address['address']=$useraddress->address;
            $address['city']=$useraddress->city;
            $address['state']=$useraddress->state;
            $address['zip_code']=$useraddress->zip_code;
            $address['lat']=$useraddress->lat;
            $address['lang']=$useraddress->lang;
            $address['is_default']=(!empty($useraddress->is_default) ? $useraddress->is_default:'');
            $address['address_type']=$useraddress->address_type;
            
            $success['params']=$params;
            $success['address']=$address;
            $response['response']=$success;
            
        //   Helper::SendNotification("Registration","New ".$user->user_type ." found");
        $admin=User::select('id','user_type','name')->where('user_type','admin')->first();
             Helper::SendNotification("Hi ".$admin->name."","Your Order status changed successfully","register",$user->id,$user->id);
             

           DB::commit();
            return response()->json($response, 200);
        }
        }
        catch(Exception $e){
        $success['statuscode'] =401;
        $success['message']="Something went wrong";
        /**
         * params value (user_id,otp,token)
        **/
          $params=[];
          $success['params']=$params;
          $response['response']=$success;
          return response()->json($response, 401);
        }
    }
    /**
     * details api
     *
     * @return \Illuminate\Http\Response
     */
    public function details()
    {
        $user = Auth::user();
        return response()->json(['success' => $user], $this->successStatus);
    }

    public function userlogout(Request $request)
    {
     try{
         $user=User::find($request->user_id);
         $delete_item=$request->token;

        $device_token=json_decode($user->device_key);

    // if($request->type=="single_logout"){
         if (($key = array_search($delete_item,$device_token)) !== false) {
         
            unset($device_token[$key]);
             
            $result=(implode(',',$device_token));
            $token=explode(',',$result);
            $user->update(['device_key'=>array_filter($token)]);
             }
        // }else{
               
        //       $user->update(['device_key'=>NULL]);  
        //      }

//         $newarr = array_filter($device_token);
// 		$user->update(['device_key'=>$newarr]);
       $success['statuscode'] =200;
       $success['message']="Logged out successfully";

       /**
        * params value (product_id,product_qty)
       **/
       $params['user_id']=$request->user_id;
       $params['token']=$request->token;
       $params['type']=$request->type;
       $success['user']=$user;
       $success['params']=$params;
       $response['response']=$success;
       return response()->json($response, 200); 
                 
     }  catch(Exception $e){
        $success['statuscode'] =401;
        $success['message']="Something went wrong";
        /**
         * params value (user_id,otp,token)
        **/
          $params=[];
          $success['params']=$params;
          $response['response']=$success;
          return response()->json($response, 401);
        }

    }

    public function storeToken(Request $request)
    {
        $user=Auth::user();
        try{
            if(!empty($user)){
                auth()->user()->update(['device_key'=>$request->token]);
               $success['statuscode'] =200;
               $success['message']="Token stored successfully";
               $params=[];
               $success['params']=$params;
               $response['response']=$success;
               return response()->json($response, 200); 
            }
        }
                catch(Exception $e){
                $success['statuscode'] =401;
                $success['message']="Something went wrong";
                /**
                 * params value (user_id,otp,token)
                **/
                  $params=[];
                  $success['params']=$params;
                  $response['response']=$success;
                  return response()->json($response, 401);
                }
    }
    
    
    
   public function user_details(Request $request){
       try{
                //user details
                    $user=User::find(Auth::user()->id);
               
                    $owners_meta_data=Owner_meta_data::where('user_id',Auth::user()->id)->first();
                    if(!empty($owners_meta_data->lat) && !empty($owners_meta_data->lang)){
                        $user_details['lat']=$owners_meta_data->lat;
                        $user_details['lang']=$owners_meta_data->lang;
                    }else{
                        $user_details['lat']="";
                        $user_details['lang']="";
                    }

                    $user_details['user_name']=$user->name;
                    $user_details['phone_number']=$user->phone;
                    $user_details['email']=$user->email;

                    if($user->user_type=="customer"){
                        $user_details['business_certificate']="";
                        $user_details['gst_certificate']=""; 
                        $user_details['shop_photo']=""; 
                    }

                    $user_details['aadhar_number']=(!empty($user->aadhar_number)?$user->aadhar_number:"");
                    
                    //Retailer
                    if($user->user_type=="retailer"){
                      $user_details['shop_name']=(isset($owners_meta_data)?$owners_meta_data->name_of_shop:""); 
                      $user_details['shop_address']=(isset($owners_meta_data)?$owners_meta_data->full_address:"");
                      $certificate=explode("/", $user->business_certificate, 2);
                    
                      $user_details['business_certificate']=(!empty($certificate)?$certificate[1]:""); 
                
                      $user_details['gst_certificate']=""; 
                      $user_details['shop_photo']=""; 
                    }
                    
                    if($user->user_type=="delivery_agent" || $user->user_type=="distributor"){
                        $address=User_address::where('user_id',$user->id)->where('is_default','true')->first();
                        $user_details['shop_name']=(isset($owners_meta_data)?$owners_meta_data->name_of_shop:""); 
                        $user_details['shop_nature']=(isset($owners_meta_data)?$owners_meta_data->nature_of_shop:""); 
                        $user_details['ownership_status']=(isset($owners_meta_data)?$owners_meta_data->ownership_type:"");
                        $user_details['address']=(isset($address)?$address->address:"");
                        // $user_details['delivery_facility']=(!empty($owners_meta_data)?$owners_meta_data->delivery_facility:"");
                        $user_details['no_of_delivery_person']=(isset($owners_meta_data)?$owners_meta_data->no_of_delivery_boys:"");
                        $certificate=(!empty($user)?explode("/", $user->business_certificate, 2):"");
                  
                        if($certificate!=""){
                        $user_details['business_certificate']=((count($certificate) >1)?$certificate[1]:""); 
                        }else{
                            $user_details['business_certificate']="";  
                        }
                        
                      $gst_certificate=(!empty($owners_meta_data)?explode("/", $owners_meta_data->gst_certificate, 2):"");
                      if($gst_certificate!=""){
                      $user_details['gst_certificate']=((count($gst_certificate)>1)?$gst_certificate[1]:""); 
                      }else{
                          $user_details['gst_certificate']="";  
                      }
                      $shop_photo=(!empty($owners_meta_data)?explode("/", $owners_meta_data->shop_photo, 2):"");
                  
                      if($shop_photo!=""){
                      $user_details['shop_photo']=((count($shop_photo)>1)?$shop_photo[1]:""); 
                      }else{
                          $user_details['shop_photo']="";  
                      }
                    }
                    if(!empty($owners_meta_data)){
                        $user_details['address']=$owners_meta_data->full_address;
                    }else{
                        $user_details['address']="";
                    }
                    
                    
                    $user_details['user_image']="";
                     $params=[];
                    $success['statuscode'] =200;
                    $success['message']="User lists";
                    $success['params']=$params;
                    $success['user_details']=$user_details;
                    $response['response']=$success;
                    return response()->json($response, 200);
   } 
        catch(Exception $e){
                $success['statuscode'] =401;
                $success['message']="Something went wrong";
                /**
                 * params value (user_id,otp,token)
                **/
                  $params=[];
                  $success['params']=$params;
                  $response['response']=$success;
                  return response()->json($response, 401);
        }
   }

    
    public function check_pincode(Request $request){
        try{
            $pincode=Pincode::where('pincode',$request->pincode)->where('status','active')->first();
            if(!empty($pincode)){
                       $success['statuscode'] =200;
                       $success['message']="Service is available";
                       $success['service_available']=true;
                       $params['pincode']=$request->pincode;
                       $success['params']=$params;
                       $response['response']=$success;
                       return response()->json($response, 200); 
            }else{
                // if(!empty($request->phone_number)){
                        $needed_servicelist=new NeededServiceList();
                        $needed_servicelist->mobile=(!empty($request->phone_number)?$request->phone_number:'');
                        $needed_servicelist->pincode=$request->pincode;
                        $needed_servicelist->name=(!empty($request->name)?$request->name:'');
                        $needed_servicelist->save();
              //  }
                        
                       $success['statuscode'] =200;
                       $success['message']="Service unavailable";
                       $success['service_available']=false;
                       $params['pincode']=$request->pincode;
                       $success['params']=$params;
                       $response['response']=$success;
                       return response()->json($response, 200); 
            }
        }       
        catch(Exception $e){
                $success['statuscode'] =401;
                $success['message']="Something went wrong";
                /**
                 * params value (user_id,otp,token)
                **/
                  $params=[];
                  $success['params']=$params;
                  $response['response']=$success;
                  return response()->json($response, 401);
        }
    } 
    
    public function list_pincode(Request $request){
        try{
            $cities=City::where('status','active')->get();
             $cityArray=array();
             foreach($cities as $city){
                 $pincode=Pincode::where('city',$city->id)->pluck('pincode');
                 $cityArr['city']=$city->city;
                 $cityArr['pincode']=$pincode;
                 if(count($pincode)>=1)
                 array_push($cityArray,$cityArr);
                 
             }
             
                       $success['statuscode'] =200;
                       $success['message']="Service lists";
                       $params['service_list']=$cityArray;
                       $success['params']=$params;
                       $response['response']=$success;
                       return response()->json($response, 200); 
            
        }       
        catch(Exception $e){
                $success['statuscode'] =401;
                $success['message']="Something went wrong";
                /**
                 * params value (user_id,otp,token)
                **/
                  $params=[];
                  $success['params']=$params;
                  $response['response']=$success;
                  return response()->json($response, 401);
        }
    } 
    
    
    
    public function delivery_chargelist(Request $request){
        try{
        $delivery=DeliveryCharges::where('status','active')->get();
 
        $success['statuscode'] =200;
        $success['message']="Delivery charges lists";
 
        /**
         * params value (product_id,product_qty)
        **/
        $params=[];
 
        $success['delivery_charges']=$delivery;
        $success['params']=$params;
        $response['response']=$success;
        return response()->json($response, 200);
        }
        catch(Exception $e){
        $success['statuscode'] =401;
        $success['message']="Something went wrong";
        /**
         * params value (user_id,otp,token)
        **/
          $params=[];

          $success['params']=$params;
          $response['response']=$success;
          return response()->json($response, 401);
        }
     }
}
