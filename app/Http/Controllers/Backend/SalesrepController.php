<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sales_rep;
use Session;
use File;
use Auth;
use App\Imports\SalesrepImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SalesrepListExport;
class SalesrepController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   $sales = Sales_rep::latest()->get();
        return view('backend.salesrepresentative.index',compact('sales'));
    }
    
    
    
    public function login()
    { 


        
        if(!Auth::user() && !auth()->guard('salesreps')->user())
        return view('backend.salesrepresentative.login');
        else

        return redirect('/dashboard');
    }

    public function login_submit(Request $request){
        $validate=$request->validate([
           'phone'=>'required',
           'password'=>'required',
        ]);
        $check_salesrep=Sales_rep::where('phone',$request->phone)->first();
        
      
        if(isset($check_salesrep)){
		
            if(\Hash::check($request->password,$check_salesrep->password)){
                   auth()->guard('salesreps')->attempt(['phone' => $request->phone, 'password' => $request->password]);
                   auth()->guard('salesreps')->login($check_salesrep,true);
                  // dd(Auth::guard('salesreps')->user());
                   return redirect('/orders');
                
            }else{//if pwd wrong
                return response()->json(['error'=>"Incorrect password"]);
            }
        }else{
             return response()->json(['error'=>"Incorrect email"]); 
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.salesrepresentative.add-sales-representative');
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
        'name'=> 'required',
        'email' => 'required|email|unique:sales_reps',
        'phone' => 'required|numeric|unique:sales_reps',
        'image' => 'required|mimes:jpg,jpeg,png',
        'status' => 'required'
       ]);
       $img_name = time().'.'.$request->image->extension();
       $request->image->move(public_path('sales_rep'),$img_name);
       $validated['image']="sales_rep".'/'.$img_name;
       Sales_rep::create($validated);
       Session::flash('success','Sales Representative Added Sucessfully');
       return redirect('sales-representative');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sales = Sales_rep::find($id);
        return response()->json(['sales'=>$sales]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sales_edit = Sales_rep::find($id);
        return view('backend.salesrepresentative.edit',compact('sales_edit'));
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
        $validated = $request->validate([
            'name'=> 'required',
            'email' => 'required|email|unique:sales_reps,email,'.$id,
            'phone' => 'required|numeric|unique:sales_reps,phone,'.$id,
            'image' => 'mimes:jpg,jpeg,png',
            'status' => 'required'
           ]);

           if(!empty($validated['image'])){
                $img_name = time().'.'.$request->image->extension();
                $request->image->move(public_path('sales_rep'),$img_name);
                $validated['image']="sales_rep".'/'.$img_name;
                $sales_update = Sales_rep::find($id);
                $image = $sales_update->image;
                $sales_update->update($validated);

                $trim = ltrim($image,'sales_rep/');
                if(File::exists(public_path('sales_rep/'.$trim))){
                    File::delete(public_path('sales_rep/'.$trim));
                }
           }else{
                $sales_update = Sales_rep::find($id);
                $sales_update->update($validated);
           }

           Session::flash('success','Sales Representative Updated Sucessfully');
           return redirect('sales-representative');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $delete = Sales_rep::find($id);
       $delete->delete();
       $image = $delete->image;
       $trim = ltrim($image,'sales_rep/');
       if(File::exists(public_path('sales_rep/'.$trim))){
            File::delete(public_path('sales_rep/'.$trim));
        }
        Session::flash('success','Sales Representative Deleted Sucessfully');
        return redirect('sales-representative');
    }
    
    
    
    
        public function import_sales_data(Request $request)
    {
        Session::flash('success','Sales representative Successfully Imported');
             Excel::import(new SalesrepImport, $request->file('file')->store('temp'));
        return back();
    }
    
    
        public function get_sales_data(Request $request)
    {
        
        return Excel::download(new SalesrepListExport, 'saleslist_reports.xlsx');
    }
    
}
