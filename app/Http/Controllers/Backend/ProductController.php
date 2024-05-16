<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\ProductDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\ChildCategory;
use App\Traits\ImageUploadTrait;
use App\Models\ProductImageGallery;
use App\Models\ProductVariant;


use App\Models\Product;
use Str;


class ProductController extends Controller
{
    use ImageUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(ProductDataTable $dataTable)
    {
        return $dataTable->render('admin.product.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $brands = Brand::all();
        return view('admin.product.create', compact('categories', 'brands'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => ['required', 'image', 'max:3000'],
            'name' => ['required', 'max:200'],
            'category' => ['required'],
            'brand' => ['required'],
            'price' => ['required'],
            'qty' => ['required'],
            'short_description' => ['required', 'max:600'],
            'long_description' => ['required'],
            'seo_title' => ['nullable','max:200'],
            'seo_description' => ['nullable','max:250'],
            'status' => ['required']
        ]);

        // Handle Image Upload
        $imagePath = $this->uploadImage($request, 'image', 'uploads');

        // Handle Date Form


        $product = new Product();
        $product->thumb_gambar = $imagePath;
        $product->nama = $request->name;
        $product->slug = Str::slug($request->name);
        $product->kategori_id = $request->category;
        $product->sub_kategori_id = $request->sub_category;
        $product->anak_kategori_id = $request->child_category;
        $product->brand_id = $request->brand;
        $product->qty = $request->qty;
        $product->deskripsi_pendek = $request->short_description;
        $product->deskripsi_panjang = $request->long_description;
        $product->video_link = $request->video_link;
        $product->sku = $request->sku;
        $product->harga = $request->price;
        $product->harga_diskon = $request->offer_price;
        $product->tanggal_diskon_mulai = $request->offer_start_date;
        $product->tanggal_diskon_akhir = $request->offer_end_date;
        $product->tipe_produk = $request->product_type;
        $product->status = $request->status;
        $product->seo_title = $request->seo_title;
        $product->seo_deskripsi = $request->seo_description;
        $product->save();

        toastr('Berhasil Membuat Produk', 'success');

        return redirect()->route('admin.products.index');
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
        $product = Product::findOrFail($id);
        $subCategories = SubCategory::where('kategori_id', $product->kategori_id)->get();
        $childCategories = ChildCategory::where('sub_kategori_id', $product->sub_kategori_id)->get();
        $categories = Category::all();
        $brands = Brand::all();

        return view('admin.product.edit', compact('product', 'categories', 'brands', 'subCategories', 'childCategories',));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'image' => ['nullable', 'image', 'max:3000'],
            'name' => ['required', 'max:200'],
            'category' => ['required'],
            'brand' => ['required'],
            'price' => ['required'],
            'qty' => ['required'],
            'short_description' => ['required', 'max:600'],
            'long_description' => ['required'],
            'seo_title' => ['nullable','max:200'],
            'seo_description' => ['nullable','max:250'],
            'status' => ['required']
        ]);

        $product = Product::findOrFail($id);


        // Handle Image Upload
        $imagePath = $this->updateImage($request, 'image', 'uploads', $product->thumb_gambar);
        
      
        $product->thumb_gambar = !empty($imagePath) ? $imagePath : $product->thumb_gambar;
        $product->nama = $request->name;
        $product->slug = Str::slug($request->name);
        $product->kategori_id = $request->category;
        $product->sub_kategori_id = $request->sub_category;
        $product->anak_kategori_id = $request->child_category;
        $product->brand_id = $request->brand;
        $product->qty = $request->qty;
        $product->deskripsi_pendek = $request->short_description;
        $product->deskripsi_panjang = $request->long_description;
        $product->video_link = $request->video_link;
        $product->sku = $request->sku;
        $product->harga = $request->price;
        $product->harga_diskon = $request->offer_price;
        $product->tanggal_diskon_mulai = $request->offer_start_date;
        $product->tanggal_diskon_akhir = $request->offer_end_date;
        $product->tipe_produk = $request->product_type;
        $product->status = $request->status;
        $product->seo_title = $request->seo_title;
        $product->seo_deskripsi = $request->seo_description;
        $product->save();
        
        toastr('Berhasil Update Produk', 'success');
        
        return redirect()->route('admin.products.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        // Delete the main product image
        $this->deleteImage($product->thumb_gambar);

        // Delete product gallery images
        $galleryImages = ProductImageGallery::where('produk_id', $product->id)->get();
        foreach($galleryImages as $image){
            $this->deleteImage($image->foto);
            $image->delete();
    }

       // Delete product variants if exist
       $variants = ProductVariant::where('produk_id', $product->id)->get();
        
       foreach($variants as $variant){
           $variant->productVariantItems()->delete();
           $variant->delete();
       }

       $product->delete();

       return response(['status' => 'success', 'message' => 'Berhasil Menghapus Produk']);



}

            /**
     * Get all product sub categories.
     */
    public function changeStatus(Request $request)
    {
       $product = Product::findOrFail($request->id);
       $product->status = $request->status == 'true' ? 1 : 0;
       $product->save();

       return response(['message' => 'Status Berhasil Di Update']);
    }

     public function getSubCategories(Request $request)
     {
        $subCategories = SubCategory::where('kategori_id', $request->id)->get();
        return $subCategories;
     }

           /**
     * Get all product anak categories.
     */
     public function getChildCategories(Request $request)
     {
        $childCategories = ChildCategory::where('sub_kategori_id', $request->id)->get();
        return $childCategories;
     }


}
