@extends('admin.layouts.master')

@section('content')
      <!-- Main Content -->
        <section class="section">
          <div class="section-header">
            <h1>Produk</h1>

          </div>

          <div class="section-body">

            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Buat Produk</h4>
                  </div>
                  <div class="card-body">
                    <form action="{{route('admin.products.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>Foto Produk</label>
                            <input type="file" class="form-control" name="image">
                        </div>

                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" name="name" value="{{old('name')}}">
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="inputState">Kategori Induk</label>
                                    <select id="inputState" class="form-control main-category" name="category">
                                      <option value="">Select</option>
                                      @foreach ($categories as $category)
                                      <option value="{{$category->id}}">{{$category->nama}}</option>
                                    @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="inputState">Sub Ketegori</label>
                                    <select id="inputState" class="form-control sub-category" name="sub_category">
                                        <option value="">Select</option>

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="inputState">Child Category</label>
                                    <select id="inputState" class="form-control child-category" name="child_category">
                                        <option value="">Select</option>
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="form-group">
                            <label for="inputState">Merek</label>
                            <select id="inputState" class="form-control" name="brand">
                                <option value="">Select</option>
                                @foreach ($brands as $brand)
                                <option value="{{$brand->id}}">{{$brand->nama}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>SKU</label>
                            <input type="text" class="form-control" name="sku" value="{{old('sku')}}">
                        </div>

                        <div class="form-group">
                            <label>Harga</label>
                            <input type="text" class="form-control" name="price" value="{{old('price')}}">
                        </div>

                        <div class="form-group">
                            <label>Harga Diskon</label>
                            <input type="text" class="form-control" name="offer_price" value="{{old('offer_price')}}">
                        </div>


                          <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tanggal Mulai Diskon</label>
                                    <input type="text" class="form-control datepicker" name="offer_start_date"  value="{{old('offer_start_date')}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tanggal Akhir Diskon</label>
                                    <input type="text" class="form-control datepicker" name="offer_end_date" value="{{old('offer_end_date')}}">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Stok Kuantitas</label>
                            <input type="number" min="0" class="form-control" name="qty" value="{{old('qty')}}">
                        </div>

                        <div class="form-group">
                            <label>Video Link</label>
                            <input type="text" class="form-control" name="video_link" value="{{old('video_link')}}">
                        </div>


                        <div class="form-group">
                            <label>Deskripsi Singkat Produk</label>
                            <textarea name="short_description" class="form-control"></textarea>
                        </div>


                        <div class="form-group">
                            <label>Deskripsi Lengkap Produk</label>
                            <textarea name="long_description" class="form-control summernote"></textarea>
                        </div>

                        <div class="form-group">
                            <label>Tipe Produk</label>
                            <select class="form-control" name="product_type">
                              <option value="">Select</option>
                              <option value="new_arrival">Produk Baru</option>
                              <option value="featured_product">Produk Unggulan</option>
                              <option value="top_product">Produk Teratas</option>
                              <option value="best_product">Produk Terbaik</option>
                            </select>
                          </div>

                        <div class="form-group">
                            <label>Seo Title</label>
                            <input type="text" class="form-control" name="seo_title" value="{{old('seo_title')}}">
                        </div>

                        <div class="form-group">
                            <label>Seo Description</label>
                            <textarea name="seo_description" class="form-control"></textarea>
                        </div>

                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" name="status">
                              <option value="1">Aktif</option>
                              <option value="0">Tidak Aktif</option>
                            </select>
                          </div>

                        <button type="submmit" class="btn btn-primary">Create</button>
                    </form>
                  </div>

                </div>
              </div>
            </div>

          </div>
        </section>
@endsection

@push('scripts')
<script>
    $(document).ready(function(){
      $('body').on('change', '.main-category', function(e){
         let id = $(this).val();
         $.ajax({
              method: 'GET',
              url: "{{route('admin.product.get-subcategories')}}",
              data:{
                id:id
              },
              success: function(data){
                $('.sub-category').html('<option value="">Select</option>')
                
                $.each(data, function(i, item){

                  $('.sub-category').append(`<option value="${item.id}">${item.nama}</option>`)

                })
              },
              error:function(xhr, status, error){
                console.log(error);
              }
         })
      })

    //   Get Kategori Anak

      $('body').on('change', '.sub-category', function(e){
         let id = $(this).val();
         $.ajax({
              method: 'GET',
              url: "{{route('admin.product.get-child-categories')}}",
              data:{
                id:id
              },
              success: function(data){
                $('.child-category').html('<option value="">Select</option>')
                
                $.each(data, function(i, item){
                  $('.child-category').append(`<option value="${item.id}">${item.nama}</option>`)
                })
              },
              error:function(xhr, status, error){
                console.log(error);
              }
         })
      })
      
    })
  </script>
@endpush
