<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Sales_rep;
use App\Models\User_address;
use App\Models\Owner_meta_data;
use Session;
use DB;
use File;
use Illuminate\Support\Facades\Storage;
use URL;
use App\Imports\DistributorListImport;
use Response;
use App\Exports\DistributorListExport;
use App\Imports\DeliveryListImport;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Validation\Rule;
class DistributorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Session::forget('success');
        // $distributors = User::where('user_type','distributor')->orderBy('id','desc')->get();
        $owners = owner_meta_data::orderBy('id','desc')->get();

        $distributors =User::join('owners_meta_data','users.id','owners_meta_data.user_id')->select('*','owners_meta_data.id as o_id','users.id as u_id','users.status as user_status')->where('owners_meta_data.user_type','distributor')->orderBy('owners_meta_data.id','desc')->get(['owners_meta_data.*','users.*']);
       
        return view('backend.distributor.index',compact('distributors','owners'));
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
        return view('backend.distributor.add',compact('sales_rep','distributors'));
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
                                    return $query->where('user_type', '=', 'distributor');
                                })],
            'owner_email' =>  ['required','email',Rule::unique('users', 'email')->where(function ($query) {
                                    return $query->where('user_type', '=', 'distributor');
                                })],
            'full_address' => 'required',
            'pincode' => 'required|integer|digits:6',
            // 'aadhar_number'=>'required',
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
            'lang' =>'required|numeric',
            'storage_capacity' => 'nullable',
            'twenty_ltres_sold_now' => 'nullable',
            'selling_jars_weekly' => 'nullable',
            'pet_bottle_sold_now' => 'nullable',
            'delivery_range' => 'nullable',
            'shop_started_at' => 'nullable',
            'agreement_date' => 'nullable',
            'additional_info' => 'nullable',
            // 'assigned_distributor' => 'required',
            'assign_sales_rep' => 'required',
            'status' => 'required'
        ]);
        
        DB::beginTransaction();
        if(!empty($request->gst_certificate)){
        $gst_certificate = time().'.'.$request->gst_certificate->extension();
        $request->gst_certificate->move(('gst_certificate'),$gst_certificate);
        $validated['gst_certificate']="gst_certificate".'/'.$gst_certificate;
        }
        if(!empty($request->govt_certificate)){
        $govt_certificate = time().'.'.$request->govt_certificate->extension();
        $request->govt_certificate->move(('govt_certificate'),$govt_certificate);
        $validated['govt_certificate']="govt_certificate".'/'.$govt_certificate;
        }
        if(!empty($request->shop_photo)){
        $shop_photo_name = time().'.'.$request->shop_photo->extension();
        $request->shop_photo->move(('shop_photo'),$shop_photo_name);
        $validated['shop_photo']="shop_photo".'/'.$shop_photo_name;
        }
        // if(!empty($request->business_certificate)){
        // $business_certificate_name = time().'.'.$request->business_certificate->extension();
        // $request->business_certificate->move(('business_certificate'),$business_certificate_name);
        // // $validated['bussiness_certificate']="bussiness_certificate".'/'. $bussiness_certificate_name;
        // $distributor_info['business_certificate']="bussiness_certificate".'/'. $business_certificate_name;
        // }
        $distributor_info['name']=$validated['name_of_owner'];
        $distributor_info['email']=$validated['owner_email'];
        $distributor_info['phone'] = $validated['owner_contact_no'];
       // $distributor_info['aadhar_number']=$validated['aadhar_number'];
        $distributor_info['status']=$validated['status'];
        $distributor_info['user_type']='distributor';
        $distributor_info['sales_rep_id']=$validated['assign_sales_rep'];
        // $distributor_info['distributor_id'] = $validated['assigned_distributor'];


        $oDistributor = User::create($distributor_info);
        $validated['user_id'] = $oDistributor->id;

        $validated['user_type'] = 'distributor';
        Owner_meta_data::create($validated);

        $user_address=new User_address();
        $user_address->user_id=$oDistributor->id;
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
        Session::flash('success','Distributor Added Successfully');
        redirect()->route('distributor.index')->with(['success'=>"Distributor Added Successfully"]);
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
        $distributor_view = Owner_meta_data::join('users','users.id','owners_meta_data.user_id')->where('owners_meta_data.id',$id)->first(['users.id','owners_meta_data.*']);
        return view('backend.distributor.view',compact('distributor_view'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $distributor_edit = Owner_meta_data::find($id);
        $owner = $distributor_edit->users;
        // echo'<pre>';
        // var_dump($owner);
        // exit;
        $business_certificate=User::select('business_certificate')->where('id',$distributor_edit->user_id)->first();
        $distributor_edit->business_certificate=$business_certificate->business_certificate;
        $sales_rep = Sales_rep::select('id','name')->get();
        $distributors = User::select('id','name')->where('user_type','distributor')->get();
        return view('backend.distributor.edit',compact('distributor_edit','sales_rep','owner','distributors'));
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
        $distributor = Owner_meta_data::find($id);
        $validated = $request->validate([
            'name_of_shop' => 'required',
            'nature_of_shop' => 'required',
            'ownership_type' => 'required',
            'name_of_owner' => 'required',
            'owner_contact_no' => ['required','integer','digits:10',Rule::unique('users', 'phone')->ignore($id)->where(function ($query) use ($distributor) {
                                    return $query->where('user_type', '=', 'distributor')->where('id','!=',$distributor->user_id);
                                })],
            'owner_email' =>  ['required','email',Rule::unique('users', 'email')->ignore($id)->where(function ($query) use ($distributor) {
                                    return $query->where('user_type', '=', 'distributor')->where('id','!=',$distributor->user_id);
                                })],
            'full_address' => 'required',
            'pincode' => 'required|integer|digits:6',
            'delivery_type' => 'nullable',
            'no_of_delivery_boys' => 'nullable',
            'gst_no' => 'nullable',
            'gst_certificate' => 'mimes:pdf,docx',
            'govt_certificate' => 'mimes:pdf,docx',
            'shop_photo' => 'mimes:jpeg,jpg,png,gif',
            'landmark' => 'nullable',
            'area_sqft' => 'nullable',
            'storage_capacity' => 'nullable',
            'twenty_ltres_sold_now' => 'nullable',
            'selling_jars_weekly' => 'nullable',
            'pet_bottle_sold_now' => 'required',
            'delivery_range' => 'nullable',
            'shop_started_at' => 'nullable',
            'lat' =>'required|numeric',
            'lang' =>'required|numeric',
            'agreement_date' => 'nullable',
            'additional_info' => 'nullable',
            // 'assigned_distributor' => 'required',
            'assign_sales_rep' => 'required',
            'status' => 'required'
        ]);
        // echo'<pre>';
        // var_dump($validated);
        // exit;
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
            // var_dump('hi');
            // exit;

            $business_certificate_name = time().'.'.$request->business_certificate->extension();
            $request->business_certificate->move(('business_certificate'),$business_certificate_name);
            // $validated['bussiness_certificate']="bussiness_certificate".'/'. $bussiness_certificate_name;

            $update_oDistributor = Owner_meta_data::find($id);
            $update_uDistributor = User::find($update_oDistributor->user_id);

            $old_businessCert = $update_uDistributor->business_certificate;

            $oldCert_trim = ltrim($old_businessCert,'business_certificate/');
            if(File::exists(('business_certificate/'.$oldCert_trim))){
                File::delete(('business_certificate/'.$oldCert_trim));
            }
            $update_distributor_info['business_certificate'] = "business_certificate".'/'.$business_certificate_name;
            $update_distributor_info['sales_rep_id'] = $validated['assign_sales_rep'];
            // $update_distributor_info['distributor_id'] = $validated['assigned_distributor'];
            $update_uDistributor->update($update_distributor_info);
            // $update_businessCert['business_certificate'] = "business_certificate".'/'.$business_certificate_name;
            // $update_uDistributor->update( $update_businessCert);

        }


        $distributor->update($validated);
        $user_table=User::where('id',$distributor->user_id)->update(['phone'=>$validated['owner_contact_no'],'name'=>$validated['name_of_owner'],'email'=>$validated['owner_email']]);
      



        
        // $oOwnerMeta = new Owner_meta_data($validated);

        // var_dump($distributor->users());
        // exit;
        // $owner = $distributor->users()->update($oOwnerMeta->toArray());

        User_address::where('user_id',$distributor->user_id)->update(['lat'=>$request->lat,'lang'=>$request->lang]);
        
          DB::commit();
        Session::put('success','Distributor Updated Successfully');
                redirect()->route('distributor.index')->with(['success'=>"Distributor updated successfully"]);
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
        $distributor_delete = Owner_meta_data::find($id);
        User::where('id',$distributor_delete->user_id)->delete();
        $distributor_delete->delete();

        $shop = $distributor_delete->shop_photo;
        $govt = $distributor_delete->govt_certificate;
        $gst = $distributor_delete->gst_certificate;

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

        Session::flash('success','Distributor Deleted Successfully');
        return redirect('distributor');
    }


    public function download_file(Request $request){
        //PDF file is stored under project/public/download/info.pdf

        $owner=Owner_meta_data::find($request->id);
        $user=User::find($owner->user_id);
        if($request->type == "govt_registration"){
            $filepath = ($owner->govt_certificate);
        }else if($request->type == "business_certificate"){
           $filepath = ($user->business_certificate);  
        }else{
           $filepath = ($owner->gst_certificate);
        }
        return Response::download($filepath);
    }
    
    public function get_distributor_data(Request $request)
    {
        return Excel::download(new DistributorListExport, 'distributorlist_reports.xlsx');
    }
    
    
    public function import_distributor_data(Request $request)
    {
    
         Session::flash('success','Distributor Successfully Imported');
             Excel::import(new DistributorListImport, $request->file('file')->store('temp'));
        return back();
    }
    
        public function import_delivery_data(Request $request)
    {
        Session::flash('success','Delivery Partners Successfully Imported');
             Excel::import(new DeliveryListImport, $request->file('file')->store('temp'));
        return back();
    }
    
    
}
