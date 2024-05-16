<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\BrandDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Traits\ImageUploadTrait;
use Str;
class BrandController extends Controller
{
    use ImageUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(BrandDataTable $dataTable)
    {
        return $dataTable->render('admin.brand.index') ;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.brand.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'logo' => ['image', 'required', 'max:2000'],
            'name' => ['required', 'max:200'],
            'is_featured' => ['required'],
            'status' => ['required']
           ]);
    
           $logoPath = $this->uploadImage($request, 'logo', 'uploads');
           $brand = new Brand();
    
           $brand->logo = $logoPath;
           $brand->nama = $request->name;
           $brand->slug = Str::slug($request->name);
           $brand->di_tampilkan = $request->is_featured;
           $brand->status = $request->status;
           $brand->save();
    
           toastr('Berhasil Membuat Merek', 'success');
           return redirect()->route('admin.brand.index');
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
        $brand = Brand::findOrFail($id);
        return view('admin.brand.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'logo' => ['image', 'max:2000'],
            'name' => ['required', 'max:200'],
            'is_featured' => ['required'],
            'status' => ['required']
           ]);

           $brand = Brand::findOrFail($id);
    
           $logoPath = $this->updateImage($request, 'logo', 'uploads', $brand->logo);
    
           $brand->logo = empty(!$logoPath) ? $logoPath : $brand->logo;
           $brand->nama = $request->name;
           $brand->slug = Str::slug($request->name);
           $brand->di_tampilkan = $request->is_featured;
           $brand->status = $request->status;
           $brand->save();
    
           toastr('Merek Berhasil Di Update', 'success');
           return redirect()->route('admin.brand.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $brand = Brand::findOrFail($id);
        $this->deleteImage($brand->logo);
        $brand->delete();

        return response(['status' => 'success', 'message' => 'Merek Berhasil Dihapus']);
    }

    public function changeStatus(Request $request)
    {
        $category = Brand::findOrFail($request->id);
        $category->status = $request->status == 'true' ? 1 : 0;
        $category->save();

        return response(['message' => 'Status Berhasil Di Update']);
    }
}
