<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Sales_rep;
use App\Models\Owner_meta_data;
use App\Models\Order;
use App\Models\User_address;
use Session;
use DB;
use File;
use Illuminate\Validation\Rule;
class DeliveryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     
     private function map($delivery_lat,$delivery_lang,$distributor_lat,$distributor_lang){
                            $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=".$delivery_lat.",".$delivery_lang."&destinations=".$distributor_lat.",".$distributor_lang."&mode=driving&language=pl-PL&key=AIzaSyAMWBCScrGIa5WPe9VB39Kiz_ER7M363uM";
                //   $dist='';
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                    $response = curl_exec($ch);
     $response_a = json_decode($response, true);
            if (isset($response_a['rows'][0]['elements'][0]['distance']['text'])) {
              $m = $response_a['rows'][0]['elements'][0]['distance']['text'];
            }else{
              $m = 0;
            }
           
            return $m;
     }
     
    public function index()
    {
        $delivery_agent = User::join('owners_meta_data','users.id','owners_meta_data.user_id')->select('*','owners_meta_data.id as o_id','users.id as u_id','users.status as user_status')->where('owners_meta_data.user_type','delivery_agent')->orderBy('users.id','desc')->get(['owners_meta_data.*','users.*']);
        return view('backend.delivery.index',compact('delivery_agent'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sales_rep = Sales_rep::select('id','name')->get();
        $distributors = User::select('id','name')->where('user_type','distributor')->get();
        return view('backend.delivery.add',compact('sales_rep','distributors'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_of_shop' => 'required',
            'nature_of_shop' => 'required',
            'ownership_type' => 'required',
            'name_of_owner' => 'required',
            'owner_contact_no' =>  ['required','integer','digits:10',Rule::unique('users', 'phone')->where(function ($query) {
                                    return $query->where('user_type', '=', 'delivery_agent');
                                })],
            'owner_email' =>  ['required','email',Rule::unique('users', 'email')->where(function ($query) {
                                    return $query->where('user_type', '=', 'delivery_agent');
                                })],
            'full_address' => 'required',
            'pincode' => 'required|integer|digits:6',
            'aadhar_number'=>'nullable',
            'delivery_type' => 'nullable',
            'no_of_delivery_boys' => 'nullable',
            'gst_no' => 'nullable',
            'gst_certificate' => 'mimes:pdf,docx',
            'govt_certificate' => 'mimes:pdf,docx',
            // 'business_certificate'=>'mimes:pdf,docx,jpg,jpeg',
            'shop_photo' => 'mimes:jpeg,jpg,png,gif',
            'landmark' => 'nullable',
            'area_sqft' => 'nullable',
            'lat' =>'required|numeric',
            'storage_capacity' => 'nullable',
            'twenty_ltres_sold_now' => 'nullable',
            'selling_jars_weekly' => 'nullable',
            'pet_bottle_sold_now' => 'nullable',
            'delivery_range' => 'nullable',
            'shop_started_at' => 'nullable',
            'agreement_date' => 'nullable',
            'additional_info' => 'nullable',
            'assigned_distributor' => 'required',
            'assign_sales_rep' => 'required',
            'status' => 'required',
            'lang'=>'required|numeric'
        ]);
         DB::beginTransaction();
        if(!empty($request->gst_certificate)){
        $gst_certificate = time().'.'.$request->gst_certificate->extension();
        $request->gst_certificate->move('gst_certificate',$gst_certificate);
        $validated['gst_certificate']="gst_certificate".'/'.$gst_certificate;
        }
        if(!empty($request->govt_certificate)){
        $govt_certificate = time().'.'.$request->govt_certificate->extension();
        $request->govt_certificate->move('govt_certificate',$govt_certificate);
        $validated['govt_certificate']="govt_certificate".'/'.$govt_certificate;
        }
        if(!empty($request->shop_photo)){
        $shop_photo_name = time().'.'.$request->shop_photo->extension();
        $request->shop_photo->move('shop_photo',$shop_photo_name);
        $validated['shop_photo']="shop_photo".'/'.$shop_photo_name;
        }
        if(!empty($request->business_certificate)){
        $business_certificate_name = time().'.'.$request->business_certificate->extension();
        $request->business_certificate->move('business_certificate',$business_certificate_name);
        // $validated['bussiness_certificate']="bussiness_certificate".'/'. $bussiness_certificate_name;
        $delivery_info['business_certificate']="bussiness_certificate".'/'. $business_certificate_name;    
       }
        $delivery_info['name']=$validated['name_of_owner'];
        $delivery_info['email']=$validated['owner_email'];
        $delivery_info['phone'] = $validated['owner_contact_no'];
        $delivery_info['aadhar_number']=$validated['aadhar_number'];
        $delivery_info['status']=$validated['status'];
        $delivery_info['user_type']='delivery_agent';
        $delivery_info['sales_rep_id']=$validated['assign_sales_rep'];
        $delivery_info['distributor_id']=$validated['assigned_distributor'];


        $odelivery = User::create($delivery_info);
        $validated['user_id'] = $odelivery->id;

        $validated['user_type'] = 'delivery_agent';
        Owner_meta_data::create($validated);
        
        $user_address=new User_address();
        $user_address->user_id=$odelivery->id;
        $user_address->full_name=$request->name_of_owner;
        $user_address->phone_number=$request->owner_contact_no;
        $user_address->is_default="true";
        $user_address->address=$request->full_address;
        $user_address->zip_code=$request->pincode;
        $user_address->lat=$request->lat;
        $user_address->lang=$request->lang;
        $user_address->full_address=$request->full_address;
        $user_address->address_type="home";
        $user_address->save();
        
        DB::commit();
        Session::flash('success','Delivery Partner Added Successfully');
                redirect()->route('delivery_agent.index')->with(['success'=>"Delivery Partner Added Successfully"]);
        return response()->json(['success'=>true]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $delivery_view = Owner_meta_data::join('users','users.id','owners_meta_data.user_id')->where('owners_meta_data.id',$id)->first(['users.id','owners_meta_data.*']);
        return view('backend.delivery.view',compact('delivery_view'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $delivery_edit = Owner_meta_data::find($id);
        // $owner = $distributor_edit->users;
        // echo'<pre>';
        // var_dump($owner);
        // exit;
        $business_certificate=User::select('business_certificate')->where('id',$delivery_edit->user_id)->first();
        $delivery_edit->business_certificate=$business_certificate->business_certificate;
        
        $sales_rep = Sales_rep::select('id','name')->get();
        $distributors = User::select('id','name')->where('user_type','distributor')->get();

        return view('backend.delivery.edit',compact('delivery_edit','sales_rep','distributors'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $delivery = Owner_meta_data::find($id);

        $validated = $request->validate([
            'name_of_shop' => 'required',
            'nature_of_shop' => 'required',
            'ownership_type' => 'required',
            'name_of_owner' => 'required',
             'owner_contact_no' => ['required','integer','digits:10',Rule::unique('users', 'phone')->ignore($id)->where(function ($query) use ($delivery) {
                                    return $query->where('user_type', '=', 'delivery_agent')
                                    ->whereNull('users.deleted_at') ->where('id','!=',$delivery->user_id);
                                })],
            'owner_email' =>  ['required','email',Rule::unique('users', 'email')->ignore($id)->where(function ($query) use ($delivery) {
                                    return $query->where('user_type', '=', 'delivery_agent')->whereNull('users.deleted_at')->where('id','!=',$delivery->user_id);
                                })],
            'full_address' => 'required',
            'pincode' => 'required|integer|digits:6',
            'delivery_type' => 'nullable',
            'no_of_delivery_boys' => 'nullable',
            'gst_no' => 'required',
            'gst_certificate' => 'mimes:pdf,docx',
            'govt_certificate' => 'mimes:pdf,docx',
            'shop_photo' => 'mimes:jpeg,jpg,png,gif',
            'landmark' => 'nullable',
            'area_sqft' => 'nullable',
            'lat' =>'required|numeric',
            'lang' =>'required|numeric',
            'storage_capacity' => 'nullable',
            'twenty_ltres_sold_now' => 'nullable',
            'selling_jars_weekly' => 'nullable',
            'pet_bottle_sold_now' => 'nullable',
            'delivery_range' => 'nullable',
            'shop_started_at' => 'nullable',
            'agreement_date' => 'nullable',
            'additional_info' => 'nullable',
            'assigned_distributor' => 'required',
            'assign_sales_rep' => 'required',
            'status' => 'required'
        ]);
         DB::beginTransaction();
        if(!empty($validated['gst_certificate'])){
            $gst_certificate = time().'.'.$request->gst_certificate->extension();
            $request->gst_certificate->move(('gst_certificate'),$gst_certificate);
            $validated['gst_certificate']="gst_certificate".'/'.$gst_certificate;

            $distributor = Owner_meta_data::find($id);
            $gst = $distributor->gst_certificate;

            $gst_trim = ltrim($gst,'gst_certificate/');
            if(File::exists(('gst_certificate/'.$gst_trim))){
                File::delete(('gst_certificate/'.$gst_trim));
            }
        }
       if(!empty($validated['govt_certificate'])){
            $govt_certificate = time().'.'.$request->govt_certificate->extension();
            $request->govt_certificate->move(('govt_certificate'),$govt_certificate);
            $validated['govt_certificate']="govt_certificate".'/'.$govt_certificate;
            $distributor = Owner_meta_data::find($id);
            $govt = $distributor->govt_certificate;

            $govt_trim = ltrim($govt,'govt_certificate/');
            if(File::exists(('govt_certificate/'.$govt_trim))){
                File::delete(('govt_certificate/'.$govt_trim));
            }
        }
        if (!empty($validated['shop_photo']) ){

            $shop_photo_name = time().'.'.$request->shop_photo->extension();
            $request->shop_photo->move(('shop_photo'),$shop_photo_name);

            $validated['shop_photo']="shop_photo".'/'.$shop_photo_name;

            $distributor = Owner_meta_data::find($id);
            $shop = $distributor->shop_photo;
            // $distributor->update($validated);
            $shop_trim = ltrim($shop,'shop_photo/');
            if(File::exists(('shop_photo/'.$shop_trim))){
                File::delete(('shop_photo/'.$shop_trim));
            }
        }

        if(isset($request->business_certificate)){

            $business_certificate_name = time().'.'.$request->business_certificate->extension();
            $request->business_certificate->move(('business_certificate'),$business_certificate_name);
            // $validated['bussiness_certificate']="bussiness_certificate".'/'. $bussiness_certificate_name;

            $update_oDelivery = Owner_meta_data::find($id);
            $update_uDelivery = User::find($update_oDelivery->user_id);

            $old_businessCert = $update_uDelivery->business_certificate;

            $oldCert_trim = ltrim($old_businessCert,'business_certificate/');
            if(File::exists(('business_certificate/'.$oldCert_trim))){
                File::delete(('business_certificate/'.$oldCert_trim));
            }
            // $update_businessCert['business_certificate'] = "business_certificate".'/'.$business_certificate_name;
            // $update_uDistributor->update( $update_businessCert);
            $update_businessCert['business_certificate'] = "business_certificate".'/'.$business_certificate_name;
              $update_businessCert['sales_rep_id'] = $validated['assign_sales_rep'];
            $update_businessCert['distributor_id'] = $validated['assigned_distributor'];
            $update_uDelivery->update($update_businessCert);
        }

        $assigned_distributor=$delivery->assigned_distributor;
        $delivery->update($validated);
        $user_table=User::where('id',$delivery->user_id)->update(['phone'=>$validated['owner_contact_no'],'name'=>$validated['name_of_owner']]);
        // $update_uDelivery = User::find($update_oDelivery->user_id);
        // $update_businessCert['business_certificate'] = "business_certificate".'/'.$business_certificate_name;
        $orders=Order::where('customer_id',$delivery->user_id)->where('status','Order placed')->update(['assigned_distributor'=>$validated['assigned_distributor']]);


        User_address::where('user_id',$delivery->user_id)->update(['lat'=>$request->lat,'lang'=>$request->lang]);

        // $oOwnerMeta = new Owner_meta_data($validated);

        // var_dump($distributor->users());
        // exit;
        // $owner = $distributor->users()->update($oOwnerMeta->toArray());

      DB::commit();
        // Session::flash('success','Delivery Partner Updated Successfully');
                  redirect()->route('delivery_agent.index')->with(['success'=>"Delivery Partner Updated Successfully"]);
         return response()->json(['success'=>true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delivery_delete = Owner_meta_data::find($id);
        User::where('id',$delivery_delete->user_id)->delete();
        $delivery_delete->delete();

        $shop = $delivery_delete->shop_photo;
        $govt = $delivery_delete->govt_certificate;
        $gst = $delivery_delete->gst_certificate;

        $shop_trim = ltrim($shop,'shop_photo/');
        $govt_trim = ltrim($govt,'govt_certificate/');
        $gst_trim = ltrim($gst,'gst_certificate/');

        if(File::exists(('gst_certificate/'.$gst_trim))){
            File::delete(('gst_certificate/'.$gst_trim));
        }
        if(File::exists(('shop_photo/'.$shop_trim))){
            File::delete(('shop_photo/'.$shop_trim));
        }
        if(File::exists(('govt_certificate/'.$govt_trim))){
            File::delete(('govt_certificate/'.$govt_trim));
        }

        Session::flash('success','Delivery Partner Deleted Successfully');
        return redirect('delivery_agent');
    }
    
    
    public function delivery_map(){
        
        

                    
                    
                    
       $type=['delivery_agent','distributor'];
      $delivery_lists=User::whereIn('user_type', $type)->where('status','1')->get();

      foreach($delivery_lists as $delivery_list){
          $A_deliverylist=User::where('user_type','delivery_agent')->get();
          $address=User_address::where('user_id',$delivery_list->id)->first();
          $owner=Owner_meta_data::where('user_id',$delivery_list->id)->first();
          
          
          
          if($delivery_list->user_type=="delivery_agent"){
                if(!empty($address)){
                    $delivery_list->lat=$address->lat;
                    $delivery_list->lang=$address->lang;
                }else{
                    $delivery_list->lat="";
                    $delivery_list->lang="";     
                }
                 $delivery_list->near_members=[];

          }else {
           
       
                if(!empty($owner)){
                    $delivery_list->lat=$owner->lat;
                    $delivery_list->lang=$owner->lang;
                }else{
                    $delivery_list->lat="";
                    $delivery_list->lang="";     
                }
                
                
                
                
                
                
                    $near_members=User::join('user_addresses','users.id','user_addresses.user_id')->join('owners_meta_data','users.id','owners_meta_data.user_id')->where('users.user_type','delivery_agent')->select('user_addresses.lat as delivery_lat','user_addresses.lang as delivery_lang','users.phone as u_phone','users.user_type','owners_meta_data.name_of_shop',DB::raw("COALESCE(6371 * acos(cos(radians(" .$delivery_list->lat . ")) 
                        * cos(radians(user_addresses.lat)) 
                        * cos(radians(user_addresses.lang) 
                        - radians(" . $delivery_list->lang . ")) 
                        + sin(radians(" . $delivery_list->lat. ")) 
                        * sin(radians(user_addresses.lat))),0) AS distance"))
                         ->having("distance", "<=", 10)
                        ->get();
                    $name=array();
                    $kms=array();
                    $phone=array();
                    
                    
                    
                    
              
                    
                    
                    foreach($near_members as $member){
                        // $dist=$this->map($delivery_list->lat,$delivery_list->lang,$member->delivery_lat,$member->delivery_lang);
       
                        

                   
                    // $dist = !empty($response_a['rows'][0]['elements'][0]['distance']['text'])?$response_a['rows'][0]['elements'][0]['distance']['text']:'';
         

                    
                        array_push($name,$member->name_of_shop);
                       // array_push($phone,$member->u_phone.' '.$dist);
                        
                        // $kms['kms']=$dist;
                        // $kms['distributor_lang']=$delivery_list->lang;
                        // $kms['delivery_lat']=$member->delivery_lat;
                        // $kms['delivery_lang']=$member->delivery_lang;
                           
                    }
                    // exit;
               
                   
                    
                        $delivery_list->near_members=$name;
                       $delivery_list->kms=$kms;
                       $delivery_list->d_phone=$phone;
                        
          }
            if(!empty($owner)){
              $delivery_list->shop_name=$owner->name_of_shop;
            }else{
              $delivery_list->shop_name=""; 
            }
      }


      return view('backend.delivery.map',['delivery_lists'=>$delivery_lists]);
    }


public function get_kms(Request $request,$id){
    
    $user=Owner_meta_data::where('user_id',$id)->first();
    

                        
                        
    if($user->user_type=="delivery_agent"){
         $html='<h1>'.$user->name_of_shop.'</h1>';
         
    }else{
        $html=    '<div id="content">' .
    '<div id="siteNotice">' .
    "</div>" .
'<h1>'.$user->name_of_shop.'</h1>'.
'<div id="bodyContent">';
        
        
    $near_members=User::join('user_addresses','users.id','user_addresses.user_id')->join('owners_meta_data','users.id','owners_meta_data.user_id')->where('users.user_type','delivery_agent')->select('user_addresses.lat as delivery_lat','user_addresses.lang as delivery_lang','users.phone as u_phone','users.user_type','owners_meta_data.name_of_shop',DB::raw("COALESCE(6371 * acos(cos(radians(" .$user->lat . ")) 
    * cos(radians(user_addresses.lat)) 
    * cos(radians(user_addresses.lang) 
    - radians(" . $user->lang . ")) 
    + sin(radians(" . $user->lat. ")) 
    * sin(radians(user_addresses.lat))),0) AS distance"))
     ->having("distance", "<=", 10)
    ->get();
    foreach($near_members as $key=>$member){
        $dist=$this->map($user->lat,$user->lang,$member->delivery_lat,$member->delivery_lang);
        $html.="<p>".($key+1).".) ".($member->name_of_shop)." - ".($member->u_phone)." - ".($dist)."</p>";

    }
        $html.='</div></div>';
    }
         return $html;
}
}
