<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use Session;
use File;
use Illuminate\Support\Str;
class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banners = Banner::latest()->get();

        return view('backend.banners.index',compact('banners'));
    }

    public function banner_status(Request $request){
        $banner_status=Banner::where('id',$request->banner_id)->first();
        if($banner_status->status=="active"){
          $banner_status=Banner::where('id',$request->banner_id)->update(['status'=>'inactive']);  
        }else{
          $banner_status=Banner::where('id',$request->banner_id)->update(['status'=>'active']);    
        }
        Session::flash('success','Status updated Sucessfully');
        return redirect()->back();
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.banners.create');
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
            'status' => 'required',
            'photo' => 'required|mimes:jpeg,png,jpg'

        ]);
  
        $img_name = time().'.'.$request->photo->extension();
        $request->photo->move('banners',$img_name);
        $validated['photo']="banners".'/'.$img_name;
        Banner::create($validated);
        Session::flash('success','Banner Added Sucessfully');
        return redirect('banner');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
              $banners = Banner::latest()->get();
        return view('backend.banners.index',compact('banners'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $banner = Banner::find($id);
        return view('backend.banners.edit',compact('banner'));
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
            'status' => 'required',
            'photo' => 'mimes:jpeg,png,jpg'

        ]);

        if(!empty($validated['photo'])){
            $img_name = time().'.'.$request->photo->extension();
            $request->photo->move('banners',$img_name);
            $validated['photo']="banners".'/'.$img_name;
            $product_update = Banner::find($id);

            $image = $product_update->photo;

            $product_update->update($validated);

            $remove = ltrim($image,'banners/');

            if(File::exists(public_path('banners/'.$remove))){
                File::delete(public_path('banners/'.$remove));
            }
        }else{
            $product_update = Banner::find($id);
            $product_update->update($validated);
        }
        Session::flash('success','Banner Updated Sucessfully');
        return redirect('banner');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $product_delete = Banner::find($id);
        $product_delete->delete();
        $image = $product_delete->photo;
        $remove = ltrim($image,'banners/');
        if(File::exists(public_path('banners/'.$remove))){
            File::delete(public_path('banners/'.$remove));
        }
        Session::flash('success','Banner Deleted Sucessfully');
        return redirect('banner');
    }
}
