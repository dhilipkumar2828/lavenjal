<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Carts;
use Session;
use File;
use Illuminate\Support\Str;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::orderBy('orderby','asc')->where('deleted','false')->get();
        

        return view('backend.product.index',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.product.add');
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
            'name' => 'required|unique:products,name',
            'customer_price' => 'required',
            'retailer_price' => 'nullable|numeric',
            'description' => 'required',
            'distributor_price' => 'nullable|numeric',
            'customer_discount' => 'nullable|numeric|lte:customer_price',
            'distributor_discount' => 'nullable|numeric|lte:distributor_price',
            'size' => 'required',
            'quantity_per_case'=>'required',
            'type' => 'required',
            'is_returnable' => 'required',
            'deposit_amount'=> 'required_if:is_returnable,yes',
            'status' => 'required',
            'image' => 'required|mimes:jpeg,png,jpg',
            'orderby'=>'required|integer'

        ]);
        
        $check_product=Product::where('orderby',$request->orderby)->count();
        if($check_product!=0){
          return response()->json(['success'=>false,'msg'=>"Orderby already taken",'type'=>'orderby']);
        }
        
        
        $slug=Str::slug($request->input('name'));
       $slug_count=Product::where('slug',$slug)->count();
       if($slug_count>0){
           $slug .=time().'-'.$slug;
       }

       
        $img_name = time().'.'.$request->image->extension();
        $request->image->move('product',$img_name);
        $validated['image']="product".'/'.$img_name;

        $validated['slug']=$slug;
        Product::create($validated);
        redirect('products')->with(['success'=>"Products Added successfully"]);
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
        $product = Product::find($id);
        return response()->json(['product'=>$product]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product_edit = Product::find($id);
        $product_edit->c_price_discount=($product_edit->customer_price- $product_edit->customer_discount);
        $product_edit->d_price_discount=($product_edit->distributor_price- $product_edit->distributor_discount);
        return view('backend.product.edit',compact('product_edit'));
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
            'name' => 'required|unique:products,name,'.$id,
            'customer_price' => 'required',
            'retailer_price' => 'nullable|numeric',
            'description' => 'required',
            'distributor_price' => 'nullable|numeric',
            'customer_discount' => 'nullable|numeric|lte:customer_price',
            'distributor_discount' => 'nullable|numeric|lte:distributor_price',
            'size' => 'required',
            'quantity_per_case'=>'required',
            'type' => 'required',
            'is_returnable' => 'required',
            'deposit_amount'=> 'required_if:is_returnable,yes',
            'status' => 'required',
            'image' => 'mimes:jpeg,png,jpg',
            'orderby'=>'required|integer'

        ]);
    
        $check_product=Product::where('id','!=',$id)->where('orderby',$request->orderby)->count();
        if($check_product!=0){
          return response()->json(['success'=>false,'msg'=>"Orderby already taken",'type'=>'orderby']);
        }
 
        
        if($validated['is_returnable']=='yes'){
            $validated['deposit_amount'] = $request->deposit_amount;
        }else{
            $validated['deposit_amount'] = null;
        }
        if(!empty($validated['image'])){
            $img_name = time().'.'.$request->image->extension();
            $request->image->move('product',$img_name);
            $validated['image']="product".'/'.$img_name;
            $product_update = Product::find($id);

            $image = $product_update->image;

            $product_update->update($validated);

            $remove = ltrim($image,'product/');

            if(File::exists(public_path('product/'.$remove))){
                File::delete(public_path('product/'.$remove));
            }
        }else{
            $product_update = Product::find($id);
            $product_update->update($validated);
        }
       // Session::flash('success','Product Updated Successfully');
        

         redirect('products')->with(['success'=>"Products updated successfully"]);
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

        $product_delete = Product::find($id);
        $carttable=Carts::where('product_id',$product_delete->id)->delete();
        $product_delete->update(['deleted'=>'true','status'=>'inactive']);
        // $image = $product_delete->image;
        // $remove = ltrim($image,'product/');
        // if(File::exists(public_path('product/'.$remove))){
        //     File::delete(public_path('product/'.$remove));
        // }
        Session::flash('success','Product Deleted Successfully');
        return redirect('products');
    }
}
