<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\City;
use App\Models\NeededServiceList;
use Session;
class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $cities=City::all();
        return view('backend.city.index',['cities'=>$cities]);
    }
    
    public function add(Request $request){
        return view('backend.city.add');
    }
    
    public function store(Request $request){
      $validate= $request->validate([
            'city'=>'required|unique:cities,city',
            'status'=>'required',
        ]);
   
        City::create($validate);
  
        Session::flash('success','City added successfully');
        return redirect('city');
    }
    
    
        public function edit(Request $request,$id){
            $city=City::find($id);
            return view('backend.city.edit',['city'=>$city]);
    }
    
    public function update(Request $request,$id){
      $validate= $request->validate([
            'city'=>'required|unique:cities,city,'.$id,
            'status'=>'required',
        ]);
   

        $city=City::find($id);
        $city->update($validate);
        Session::flash('success','City updated successfully');
        return redirect('city');
    }
    
    public function status(Request $request){
            $pincode=City::find($request->city_id);
            if($pincode->status=='active'){
                $pincode->update(['status'=>'inactive']);
            }else{
                $pincode->update(['status'=>'active']);
            }
            
           return response()->json(['success'=>true]);
    }
    
    public function destroy(Request $request,$id){
            $city=City::find($id);
            $city->delete();
            Session::flash('success','City Deleted Successfully');
             return redirect('city');
    }
 
     public function unavailable_lists()
    {

        $cities=NeededServiceList::orderBy('id','desc')->get();
        return view('backend.city.unavailable_lists',['cities'=>$cities]);
    }   
    
    public function unavalaible_city_destroy(Request $request){
        $city_id=explode(',',$request->checked_lists);
        
        foreach($city_id as $c){
            $servicelist=NeededServiceList::where('id',$c)->delete();
        }
        Session::flash('success','City deleted successfully');
        return redirect('unavailable_lists');
    }
}
