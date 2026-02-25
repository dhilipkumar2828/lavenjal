<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pincode;
use App\Models\City;
use Session;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PincodeImport;
use App\Exports\PincodeExport;
class PincodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $pincodes=Pincode::latest()->get();
        return view('backend.pincode.index',['pincodes'=>$pincodes]);
    }
    
    public function add(Request $request){
        $cities=City::where('status','active')->get();
        return view('backend.pincode.add',['cities'=>$cities]);
    }
    
    public function store(Request $request){
      $validate= $request->validate([
            'pincode'=>'required',
            'city'=>'required',
            'status'=>'required',
        ]);
        $check_duplicate=Pincode::whereIn('pincode',explode(',',$request->pincode))->get();
        if(count($check_duplicate) >0){
            return redirect()->back()->withErrors(['pincode' => 'Pincode already exists']);
        }
        $pincode=explode(',',$validate['pincode']);
        foreach($pincode as $p){
            $pincode=new Pincode;
            $pincode->city=$request->city;
            $pincode->pincode=$p;
            $pincode->status=$request->status;
            $pincode->save();
        }
  
        Session::flash('success','Pincode added successfully');
        return redirect('pincode');
    }
    
    //import pincode
    public function import_pincode_data(Request $request){
   
        Excel::import(new PincodeImport, $request->file('import_pincode')->store('temp'));
        return back();
    }
    
    //export download
    public function get_pincode_data(Request $request)
    {
        return Excel::download(new PincodeExport,'pincode_list_reports.xlsx');
    }
    
    
        public function edit(Request $request,$id){
            $pincode=Pincode::find($id);
             $cities=City::where('status','active')->get();
            return view('backend.pincode.edit',['pincode'=>$pincode,'cities'=>$cities]);
    }
    
    public function update(Request $request,$id){
      $validate= $request->validate([
            'city'=>'required',
            'pincode'=>'required|integer',
            'status'=>'required',
        ]);
        $check_duplicate=Pincode::whereIn('pincode',explode(',',$request->pincode))->where('id','!=',$id)->get();
        if(count($check_duplicate) >0){
            return redirect()->back()->withErrors(['pincode' => 'Pincode already exists']);
        }
        
        $pincode=Pincode::find($id);
        $pincode->update($validate);
        Session::flash('success','Pincode updated successfully');
        return redirect('pincode');
    }
    
    public function status(Request $request){
            $pincode=Pincode::find($request->pincode_id);
            if($pincode->status=='active'){
                $pincode->update(['status'=>'inactive']);
            }else{
                $pincode->update(['status'=>'active']);
            }
            
           return response()->json(['success'=>true]);
    }
    
    public function destroy(Request $request,$id){
            $pincode=Pincode::find($id);
            $pincode->delete();
            Session::flash('success','Pincode Deleted Successfully');
             return redirect('pincode');
    }
    
}
