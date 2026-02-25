<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Session;
use App\Models\User_address;
use DB;
use Illuminate\Validation\Rule;
class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      //  Session::forget('success');
        $users=User::where('user_type','customer')->orderBy('id','desc')->get();      
       return view('backend.customer.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user=User::find($id);
        $orders=DB::table('orders')->join('users','users.id','=','orders.customer_id')->where('users.id',$id)->orderBy('orders.id','desc')->get(['orders.*','users.*','orders.status as order_status','users.id as user_id','orders.created_at as order_created']);
        $addresses=User_address::where('user_id',$user->id)->get();

        return view('backend.customer.view',compact('user','orders','addresses'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        
       $user=User::find($id);
   
        return response()->json(['user'=>$user]);
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
        $id = $request->customer_id;
     
        $validated = $request->validate([
            'name' => 'required',
            'email' =>  ['required',Rule::unique('users', 'email')->ignore($id)->where(function ($query) use ($id) {
                                    return $query->where('user_type', '=', 'customer')->whereNull('deleted_at');
                                })],
            'phone' => 'required|numeric',
            'status' => 'required',

        ]);
        $user=User::find($id);
        $user->update($validated);  
        Session::flash('success','Customer updated successfully');
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
        $user=User::find($id);
        $user->delete();
        Session::flash('success','Customer deleted successfully');
        return redirect()->back();
    }
}
