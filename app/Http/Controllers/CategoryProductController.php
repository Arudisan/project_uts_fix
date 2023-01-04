<?php

namespace App\Http\Controllers;

use App\Models\CategoryProduct;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreCategoryProductRequest;
use App\Http\Requests\UpdateCategoryProductRequest;

class CategoryProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = CategoryProduct::paginate(2);
        return view('admin.pages.category.list', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = new  CategoryProduct();
        return view('admin.pages.category.form', ['category' => $category]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCategoryProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryProductRequest $request)
    {
        $data = $request->all();
        CategoryProduct::create($data);
        return redirect()->route('category.index')->with('notif', 'berhasil euy');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CategoryProduct  $categoryProduct
     * @return \Illuminate\Http\Response
     */
    public function show(CategoryProduct $categoryProduct)
    {
        $categoryProduct = $categoryProduct->load(['products'])->first();
        return view('admin.pages.category.list-category', compact('categoryProduct'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CategoryProduct  $categoryProduct
     * @return \Illuminate\Http\Response
     */
    public function edit(CategoryProduct $category)
    {
        if (!Auth::user()->hasPermissionTo('form categoryProduct')) {
            return redirect()->route('category.index')->with('notif', 'Tidak Ada Akses');
        }
        return view(
            'admin.pages.category.form',
            [
                'category' => $category,
                'title' => "edit Form Category",
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCategoryProductRequest  $request
     * @param  \App\Models\CategoryProduct  $categoryProduct
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryProductRequest $request, CategoryProduct $category)
    {
        $data = $request->all();
        $category->update($data);
        return redirect()->route('category.index')->with('notif', 'berhasil euy');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CategoryProduct  $categoryProduct
     * @return \Illuminate\Http\Response
     */
    public function destroy(CategoryProduct $category)
    {
        $category->delete();
        return redirect()->route('category.index')->with('notif', 'berhasil CRUD euy');
    }
}
