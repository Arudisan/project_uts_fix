<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;
use App\Models\CategoryProduct;
use Illuminate\Support\Facades\File;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $search = $request->input('search');
        $filter = $request->input('filter');
        $data = Products::with(['category']);
        $categories = CategoryProduct::get();



        if ($search) {
            $data->where(function ($query) use ($search) {
                $query->where('title', 'like', "%$search%")
                    ->orWhere('description', 'like', "%$search%");
            });
        }

        if ($filter) {
            $data->where(function ($query) use ($filter) {
                $query->where('category_id', '=', $filter);
            });
        }

        $data = $data->paginate(10);
        return view('pages.product.list',[
            'data'=>$data,
            'categories'=>$categories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $product=new Products();
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
        if($image){
            $data['image'] = $image->store('image/product','public');
        }
        Products::create($data);
        return redirect()->route('product.index')->with('notif', 'Data Berhasil di Input');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Products $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Products $product)
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
    public function update(UpdateProductRequest $request,Products $product)
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

        return redirect()->route('product.index')->with('notif', 'Data Berhasil di Input');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Products $product)
    {
        $product->destroy($product->id);
        File::delete(storage_path('app/public/').$product->image);
        return redirect()->route('product.index')->with('notif', 'Data Berhasil di Hapus');
    }
}
