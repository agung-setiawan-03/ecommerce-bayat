<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\CategoryDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CategoryDataTable $dataTable)
    {
        return $dataTable->render('admin.category.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'icon' => ['required', 'not_in:empty'],
            'name' => ['required','max:200' ,'unique:categories,nama'],
            'status' => ['required']
           ]);
    
           $category = new Category();
    
           $category->icon = $request->icon;
           $category->nama = $request->name;
           $category->slug = Str::slug($request->name);
           $category->status = $request->status;
           $category->save();
    
           toastr('Berhasil Membuat Kategori Induk', 'success');
           
           return redirect()->route('admin.category.index');
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
        $category = Category::findOrFail($id);
        return view('admin.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'icon' => ['required', 'not_in:empty'],
            'name' => ['required','max:200' ,'unique:categories,nama,'.$id],
            'status' => ['required']
           ]);
    
           $category = Category::findOrFail($id);
    
           $category->icon = $request->icon;
           $category->nama = $request->name;
           $category->slug = Str::slug($request->name);
           $category->status = $request->status;
           $category->save();
    
           toastr('Berhasil Update Kategori Induk', 'success');
           
           return redirect()->route('admin.category.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    { $category = Category::findOrFail($id);
        $subCategory = SubCategory::where('kategori_id', $category->id)->count();
        if($subCategory > 0){
        return response(['status' => 'error', 'message' => 'Kategori induk memiliki sub kategori, jika anda ingin mehapusnya maka anda harus menghapus sub kategori terlebih dahulu']);
        }
        $category->delete();

        return response(['status' => 'success','message' => 'Berhasil Menghapus Kategori Induk']);
    }

    public function changeStatus(Request $request)
    {
        $category = Category::findOrFail($request->id);
        $category->status = $request->status == 'true' ? 1 : 0;
        $category->save();

        return response(['message' => 'Status Berhasil Di Update']);
    }
}
