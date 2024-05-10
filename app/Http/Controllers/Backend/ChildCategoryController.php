<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\ChildCategoryDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\ChildCategory;
use App\Models\SubCategory;
use Str;


class ChildCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ChildCategoryDataTable $dataTable)
    {   
        return $dataTable->render('admin.child-category.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.child-category.create', compact('categories'));
    }

        /**
     * Get sub categories.
     */
    public function getSubCategories(Request $request)
    {
        $subCategories = SubCategory::where('kategori_id', $request->id)->where('status', 1)->get();
        return $subCategories;
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category' => ['required'],
            'sub_category' => ['required'],
            'name' => ['required', 'max:200', 'unique:child_categories,nama'],
            'status' => ['required']
        ]);
        
        $childCategory = new ChildCategory();

        $childCategory->kategori_id = $request->category;
        $childCategory->sub_kategori_id = $request->sub_category;
        $childCategory->nama = $request->name;
        $childCategory->slug = Str::slug($request->name);
        $childCategory->status = $request->status;
        $childCategory->save();

        toastr('Berhasil Membuat Kategori Anak', 'success');
        
        return redirect()->route('admin.child-category.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $categories = Category::all();
        $childCategory = ChildCategory::findOrFail($id);
        $subCategories = SubCategory::where('kategori_id', $childCategory->kategori_id)->get();

        return view('admin.child-category.edit', compact('categories','childCategory', 'subCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'category' => ['required'],
            'sub_category' => ['required'],
            'name' => ['required', 'max:200', 'unique:child_categories,nama,'.$id],
            'status' => ['required']
        ]);
        
        $childCategory = ChildCategory::findOrFail($id);

        $childCategory->kategori_id = $request->category;
        $childCategory->sub_kategori_id = $request->sub_category;
        $childCategory->nama = $request->name;
        $childCategory->slug = Str::slug($request->name);
        $childCategory->status = $request->status;
        $childCategory->save();

        toastr('Kategori Anak Berhasil Di Update', 'success');
        
        return redirect()->route('admin.child-category.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $childCategory = ChildCategory::findOrFail($id);
        $childCategory->delete();

        return response(['status' => 'success', 'message' => 'Berhasil Dihapus']);
    }

    public function changeStatus(Request $request)
    {
        $category = ChildCategory::findOrFail($request->id);
        $category->status = $request->status == 'true' ? 1 : 0;
        $category->save();

        return response(['message' => 'Status Berhasil Di Update']);
    }
}
