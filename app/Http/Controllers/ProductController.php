<?php

namespace App\Http\Controllers;

use App\Models\product;
use Illuminate\Http\Request;
use App\Models\CategoryProduct;
use Illuminate\Support\Facades\File;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=product::get();
        return view('pages.product.list',['data'=>$data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $product=new product();
        return view('pages.product.form',[
            'product'=>$product,
            'categories' => CategoryProduct::get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {

        $data=$request->all();
        $image = $request->file('image');
        $image = $request->file('image');
        if($image){
            $data['image'] = $image->store('image/product','public');
        }
        product::create($data);
        return redirect()->route('product.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(product $product)
    {
        return view('pages.product.form',[
            'product'=>$product,
            'categories' => CategoryProduct::get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request,product $product)
    {
        $data=$request->all();
        $image=$request->file('image');
        if($image){
            $exists= File::exists(storage_path('app/public/') . $product->image);
            if($exists){
                File::delete(storage_path('app/public/') . $product->image);
            }
            $data['image'] = $image->store('image/product','public');
        }
        $product->update($data);

        return redirect()->route('product.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(product $product)
    {
        $product->destroy($product->id);
        File::delete(storage_path('app/public/').$product->image);
        return redirect()->route('product.index');
    }
}
