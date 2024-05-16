<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\ProductVariantItemDataTable;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductVariantItem;


class ProductVariantItemController extends Controller
{
    public function index(ProductVariantItemDataTable $dataTable, $productId, $variantId)
    {
        $product = Product::findOrFail($productId);
        $variant = ProductVariant::findOrFail($variantId);
        return $dataTable->render('admin.product.product-variant-item.index', compact('product', 'variant'));
    }

    public function create(string $productId, string $variantId)
    {
        $variant = ProductVariant::findOrFail($variantId);
        $product = Product::findOrFail($productId);

        return view('admin.product.product-variant-item.create', compact('variant', 'product'));
    }

     // Store data
     public function store(Request $request)
     {
         
         $request->validate([
             'variant_id' => ['integer', 'required'],
             'name' => ['required', 'max:200'],
             'price' => ['integer', 'required'],
             'is_default' => ['required'],
             'status' => ['required']
         ]);
 
         $variantItem = new ProductVariantItem();
         $variantItem->produk_varian_id = $request->variant_id;
         $variantItem->nama = $request->name;
         $variantItem->harga = $request->price;
         $variantItem->produk_default = $request->is_default;
         $variantItem->status = $request->status;
         $variantItem->save();
 
         toastr('Berhasil Membuat Item Variasi Produk', 'success', 'succes');
 
         return redirect()->route('admin.products-variant-item.index', 
         ['productId' => $request->product_id, 'variantId' => $request->variant_id]);
         
 
     }

     public function edit(string $variantItemId)
     {
         $variantItem = ProductVariantItem::findOrFail($variantItemId); 
         return view('admin.product.product-variant-item.edit', compact('variantItem'));
     }

     public function update(Request $request, string $variantItemId)
     {
         $request->validate([
             'name' => ['required', 'max:200'],
             'price' => ['integer', 'required'],
             'is_default' => ['required'],
             'status' => ['required']
         ]);
 
         $variantItem = ProductVariantItem::findOrFail($variantItemId);
         $variantItem->nama = $request->name;
         $variantItem->harga = $request->price;
         $variantItem->produk_default = $request->is_default;
         $variantItem->status = $request->status;
         $variantItem->save();
 
         toastr('Berhasil Update Item Variasi Produk', 'success', 'succes');
 
         return redirect()->route('admin.products-variant-item.index', 
         ['productId' => $variantItem->productVariant->produk_id, 'variantId' => $variantItem->produk_varian_id]);
     }

     public function destroy(string $variantItemId)
     {
         $variantItem = ProductVariantItem::findOrFail($variantItemId);
         $variantItem->delete();
 
         return response(['status' => 'success', 'message' => 'Item Variasi Berhasil Di Hapus']);
     }
 
     public function changeStatus(Request $request)
     {
         $variantItem = ProductVariantItem::findOrFail($request->id);
         $variantItem->status = $request->status == 'true' ? 1 : 0;
         $variantItem->save();
 
         return response(['message' => 'Status Berhasil Di Update']);
     }
}
