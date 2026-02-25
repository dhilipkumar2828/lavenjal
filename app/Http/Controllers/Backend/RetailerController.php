<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Sales_rep;
use App\Models\Owner_meta_data;
use App\Models\Order;
use Session;
use App\Models\User_address;
use DB;
use File;
use Illuminate\Validation\Rule;
class RetailerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $retailers=User::where('user_type','retailer')->get();
        $retailers = User::join('owners_meta_data','users.id','owners_meta_data.user_id')->select('*','owners_meta_data.id as o_id','users.id as u_id','users.status as user_status')->where('owners_meta_data.user_type','retailer')->orderBy('users.id','desc')->get(['owners_meta_data.*','users.*']);
        // echo'<pre>';
        // var_dump($retailers);
        // exit;

        return view('backend.retailer.index',compact('retailers'));

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
        return view('backend.retailer.add',compact('sales_rep','distributors'));
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
            // 'nature_of_shop' => 'required',
            // 'ownership_type' => 'required',
            'name_of_owner' => 'required',
            'owner_contact_no' =>  ['required','integer','digits:10',Rule::unique('users', 'phone')->where(function ($query)  {
                                    return $query->where('user_type', '=', 'retailer');
                                })],
            'owner_email' =>  ['required','email',Rule::unique('users', 'email')->where(function ($query) {
                                    return $query->where('user_type', '=', 'retailer');
                                })],
            'full_address' => 'required',
            'pincode' => 'required|integer|digits:6',
            'aadhar_number'=>'nullable',
            // 'delivery_type' => 'required',
            // 'no_of_delivery_boys' => 'required',
            'gst_no' => 'nullable',
            // 'business_certificate'=>'mimes:pdf,docx,jpg,jpeg',
            // 'shop_photo' => 'mimes:jpeg,jpg,png,gif',
            'landmark' => 'nullable',
            'area_sqft' => 'nullable',
            'lat' =>'required|numeric',
            'lang'=>'required|numeric',
            'storage_capacity' => 'nullable',
            'twenty_ltres_sold_now' => 'nullable',
            'selling_jars_weekly' => 'nullable',
            'pet_bottle_sold_now' => 'nullable',
            'delivery_range' => 'nullable',
            'shop_started_at' => 'nullable',
            'agreement_date' => 'required',
            'additional_info' => 'nullable',
            'assigned_distributor' => 'required',
            'assign_sales_rep' => 'required',
            'status' => 'required'
        ]);

        DB::beginTransaction();
        
        // if(!empty($request->gst_certificate)){
        //     $gst_certificate = time().'.'.$request->gst_certificate->extension();
        //     $request->gst_certificate->move(('gst_certificate'),$gst_certificate);
        //     $validated['gst_certificate']="gst_certificate".'/'.$gst_certificate;
        // }
        // if(!empty($request->govt_certificate)){
        //     $govt_certificate = time().'.'.$request->govt_certificate->extension();
        //     $request->govt_certificate->move(('govt_certificate'),$govt_certificate);
        //     $validated['govt_certificate']="govt_certificate".'/'.$govt_certificate;
        // }
        if(!empty($request->shop_photo)){
            $shop_photo_name = time().'.'.$request->shop_photo->extension();
            $request->shop_photo->move(('shop_photo'),$shop_photo_name);
            $validated['shop_photo']="shop_photo".'/'.$shop_photo_name;
        }
        if(!empty($request->business_certificate)){
            $business_certificate_name = time().'.'.$request->business_certificate->extension();
            $request->business_certificate->move(('business_certificate'),$business_certificate_name);
            $retailer_info['business_certificate']="bussiness_certificate".'/'. $business_certificate_name;
        }
        // $validated['bussiness_certificate']="bussiness_certificate".'/'. $bussiness_certificate_name;

        $retailer_info['name']=$validated['name_of_owner'];
        $retailer_info['email']=$validated['owner_email'];
        $retailer_info['phone'] = $validated['owner_contact_no'];
        $retailer_info['aadhar_number']=$validated['aadhar_number'];
        $retailer_info['status']=$validated['status'];
        $retailer_info['user_type']='retailer';
        $retailer_info['sales_rep_id']=$validated['assign_sales_rep'];
        $retailer_info['distributor_id'] = $validated['assigned_distributor'];


        $oRetailer = User::create($retailer_info);
        $validated['user_id'] = $oRetailer->id;

        $validated['user_type'] = 'retailer';
        Owner_meta_data::create($validated);
        
        
        $user_address=new User_address();
        $user_address->user_id=$oRetailer->id;
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
        
        redirect()->route('retailer.index')->with(['success'=>"Retailer Added Successfully"]);
        Session::flash('success','Retailer Added Successfully');
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
        $retailer_view = Owner_meta_data::join('users','users.id','owners_meta_data.user_id')->where('owners_meta_data.id',$id)->first(['users.id','owners_meta_data.*','users.business_certificate']);
      
        return view('backend.retailer.view',compact('retailer_view'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $retailer_edit = Owner_meta_data::find($id);
        // $owner = $distributor_edit->users;
        // echo'<pre>';
        // var_dump($owner);
        // exit;
        $business_certificate=User::select('business_certificate')->where('id',$retailer_edit->user_id)->first();
        $retailer_edit->business_certificate=$business_certificate->business_certificate;
        $sales_rep = Sales_rep::select('id','name')->get();
        $distributors = User::select('id','name')->where('user_type','distributor')->get();
     
        return view('backend.retailer.edit',compact('retailer_edit','sales_rep','distributors'));
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
        $retailer = Owner_meta_data::find($id);
        $validated = $request->validate([
            'name_of_shop' => 'required',
            // 'nature_of_shop' => 'required',
            // 'ownership_type' => 'required',
            'name_of_owner' => 'required',
            'owner_contact_no' => ['required','integer','digits:10',Rule::unique('users', 'phone')->ignore($id)->where(function ($query) use ($retailer) {
                                    return $query->where('user_type', '=', 'retailer')->where('id','!=',$retailer->user_id);
                                })],
            'owner_email' =>  ['required','email',Rule::unique('users', 'email')->ignore($id)->where(function ($query) use ($retailer) {
                                    return $query->where('user_type', '=', 'retailer')->where('id','!=',$retailer->user_id);
                                })],
            'full_address' => 'required',
            'pincode' => 'required|integer|digits:6',
            // 'delivery_type' => 'required',
            // 'no_of_delivery_boys' => 'required',
            'gst_no' => 'nullable',
            // 'gst_certificate' => 'mimes:pdf,docx',
            // 'govt_certificate' => 'mimes:pdf,docx',
            // 'shop_photo' => 'mimes:jpeg,jpg,png,gif',
            'landmark' => 'nullable',
            'area_sqft' => 'nullable',
            'lat' =>'required|numeric',
            'storage_capacity' => 'nullable',
            'twenty_ltres_sold_now' => 'nullable',
            'selling_jars_weekly' => 'nullable',
            'pet_bottle_sold_now' => 'nullable',
            // 'delivery_range' => 'required',
            'shop_started_at' => 'nullable',
            'agreement_date' => 'nullable',
            'additional_info' => 'nullable',
            'assigned_distributor'=>'required',
            'assign_sales_rep' => 'required',
            'status' => 'required',
            'aadhar_number'=>'nullable'
        ]);
        // echo'<pre>';
        // var_dump($validated);
        // exit;

    //     if(!empty($validated['gst_certificate'])){
    //         $gst_certificate = time().'.'.$request->gst_certificate->extension();
    //         $request->gst_certificate->move(('gst_certificate'),$gst_certificate);
    //         $validated['gst_certificate']="gst_certificate".'/'.$gst_certificate;

    //         $distributor = Owner_meta_data::find($id);
    //         $gst = $distributor->gst_certificate;

    //         $gst_trim = ltrim($gst,'gst_certificate/');
    //         if(File::exists(('gst_certificate/'.$gst_trim))){
    //             File::delete(('gst_certificate/'.$gst_trim));
    //         }
    //     }
    //   if(!empty($validated['govt_certificate'])){
    //         $govt_certificate = time().'.'.$request->govt_certificate->extension();
    //         $request->govt_certificate->move(('govt_certificate'),$govt_certificate);
    //         $validated['govt_certificate']="govt_certificate".'/'.$govt_certificate;
    //         $distributor = Owner_meta_data::find($id);
    //         $govt = $distributor->govt_certificate;

    //         $govt_trim = ltrim($govt,'govt_certificate/');
    //         if(File::exists(('govt_certificate/'.$govt_trim))){
    //             File::delete(('govt_certificate/'.$govt_trim));
    //         }
    //     }
    DB::beginTransaction();
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
            // var_dump('hi');
            // exit;

            $business_certificate_name = time().'.'.$request->business_certificate->extension();
            $request->business_certificate->move(('business_certificate'),$business_certificate_name);
            // $validated['bussiness_certificate']="bussiness_certificate".'/'. $bussiness_certificate_name;

            $update_oRetailer = Owner_meta_data::find($id);
            $update_uRetailer = User::find($update_oRetailer->user_id);

            $old_businessCert = $update_uRetailer->business_certificate;

            $oldCert_trim = ltrim($old_businessCert,'business_certificate/');
            if(File::exists(('business_certificate/'.$oldCert_trim))){
                File::delete(('business_certificate/'.$oldCert_trim));
            }
            // $update_businessCert['business_certificate'] = "business_certificate".'/'.$business_certificate_name;
            // $update_uDistributor->update( $update_businessCert);
            $update_businessCert['business_certificate'] = "business_certificate".'/'.$business_certificate_name;
              $update_businessCert['sales_rep_id'] = $validated['assign_sales_rep'];
            $update_businessCert['distributor_id'] = $validated['assigned_distributor'];
            $update_uRetailer->update($update_businessCert);
        }

        $validated['lang']=(!empty($request->lang)?$request->lang:'');
       
        $retailer->update($validated);

        $user_table=User::where('id',$retailer->user_id)->update(['phone'=>$validated['owner_contact_no'],'name'=>$validated['name_of_owner'],'aadhar_number'=>$validated['aadhar_number']]);

        //$update_businessCert['business_certificate'] = "business_certificate".'/'.$business_certificate_name;



        // $oOwnerMeta = new Owner_meta_data($validated);

        // var_dump($distributor->users());
        // exit;
        // $owner = $distributor->users()->update($oOwnerMeta->toArray());
         User_address::where('user_id',$retailer->user_id)->update(['lat'=>$request->lat,'lang'=>$request->lang]);
           DB::commit();
        redirect()->route('retailer.index')->with(['success'=>"Retailer Updated Successfully"]);
        return response()->json(['success'=>true]);
        // return redirect('retailer')->with('message','Retailer updated Successfully');
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $retailer_delete = Owner_meta_data::find($id);
        User::where('id',$retailer_delete->user_id)->delete();
        $retailer_delete->delete();

        $shop = $retailer_delete->shop_photo;
        $govt = $retailer_delete->govt_certificate;
        $gst = $retailer_delete->gst_certificate;

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

        Session::flash('success','Retailer Deleted Successfully');
        return redirect('retailer');
    }
    
    public function update_status(Request $request){
        $user=User::where('id',$request->user_id)->first();
        if($user->status==1){
            User::where('id',$request->user_id)->update(['status'=>'0']);
        }else{
            User::where('id',$request->user_id)->update(['status'=>'1']);
        }

    }
}
