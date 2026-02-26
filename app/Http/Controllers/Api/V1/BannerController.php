<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Exception;

class BannerController extends Controller
{

    public function view(Request $request)
    {
            try{
            $banners=Banner::where('status','active')->get(['photo']);
            $bannerlist=array();
            
            $url=url('/');
            foreach($banners as $banner){
              array_push($bannerlist,$url.'/'.$banner->photo);  
            }

            $success['statuscode'] =200;
            $success['message']="Otp sent successfully";
            /**
             * params value (user_id,otp,token)
            **/
            $params=[];
            $success['params']=$params;
            $success['banners']=$bannerlist;
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
 
 public function sockettest(){
     
 }

}
