@extends('admin.layouts.master');

@section('content')
      <!-- Main Content -->
      <section class="section">
        <div class="section-header">
          <h1>Item Varian Produk </h1>

        </div>

        <div class="section-body">
      
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h4>Update Item Varian Produk</h4>

                </div>
                <div class="card-body">
                    <form action="{{route('admin.products-variant-item.update', $variantItem->id)}}" method="POST">
                        @csrf 
                        @method('PUT')
                        <div class="form-group">
                            <label>Nama Varian</label>
                            <input type="text" name="variant_name" class="form-control" value="{{$variantItem->productVariant->nama}}" readonly>
                          </div>



                          <div class="form-group">
                            <label>Nama Item</label>
                            <input type="text" name="name" class="form-control" value="{{$variantItem->nama}}">
                          </div>

                          <div class="form-group">
                            <label>Harga <code>(Jika harga item variasi berbeda maka silahkan isi kolom dibawah ini, tetapi jika sama maka tidak perlu diisi)</code></label>
                            <input type="text" name="price" class="form-control" value="{{$variantItem->harga}}">
                          </div>


                          <div class="form-group">
                            <label>Produk Default</label>
                            <select class="form-control" name="is_default">
                                <option {{$variantItem->produk_default == 1 ? 'selected' : ''}} value="1">Iya</option>
                                <option {{$variantItem->produk_default == 0 ? 'selected' : ''}} value="0">Tidak</option>
                            </select>
                          </div>
                            


                            <div class="form-group">
                              <label>Status</label>
                              <select class="form-control" name="status">
                                <option {{$variantItem->status == 1 ? 'selected' : ''}} value="1">Aktif</option>
                                <option {{$variantItem->status == 0 ? 'selected' : ''}} value="0">Tidak Aktif</option>
                              </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
                      </form>
                </div>

              </div>
            </div>
          </div>

        </div>
      </section>
    
@endsection
