<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\CategoryProduct;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

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
        // remember : tolong cekin key all-products yang ada dicache
        // jika ada,langsung ambil
        // jika gaada,query dulu,terus simpen ke cache selama 60 detik
        //setelah itu baru return ke client
        $data = Cache::remember('all-products', 60, function () use ($search, $filter) {
            $data = Product::with(['category']);
            // $categories = CategoryProduct::get();

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
            return $data->get();
        });
        return view('admin.pages.product.list', compact('data'), [
            'tittle' => 'List Product',
            // 'data' => $data,
            // 'categories' => $categories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $product = new Product();

        return view('admin.pages.product.form', [
            'product' => $product,
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

        $data = $request->all();
        // dd($data);
        $image = $request->file('image');
        if ($image) {
            $data['image'] = $image->store('image/product', 'public');
        }

        Product::create($data);

        return redirect()->route('product.index')->with('notif', 'Data Berhasil di Input');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        if (!Auth::user()->hasPermissionTo('form product')) {
            return redirect()->route('product.index')->with('notif', 'tidak ada akses');
        }
        return view('admin.pages.product.form', [
            'title' => 'Edit Product',
            'product' => $product,
            'categories' => CategoryProduct::where('status', 'active'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $data = $request->all();
        $image = $request->file('image');
        if ($image) {
            $exists = File::exists(storage_path('app/public/') . $product->image);
            if ($exists) {
                File::delete(storage_path('app/public/') . $product->image);
            }
            $data['image'] = $image->store('image/product', 'public');
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
    public function destroy(Product $product)
    {
        $product->destroy($product->id);
        File::delete(storage_path('app/public/') . $product->image);
        return redirect()->route('product.index')->with('notif', 'Data Berhasil di Hapus');
    }
}
