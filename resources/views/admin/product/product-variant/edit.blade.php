@extends('admin.layouts.master');

@section('content')
      <!-- Main Content -->
      <section class="section">
        <div class="section-header">
          <h1>Varian Produk</h1>

        </div>

        <div class="section-body">
      
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h4>Update Varian Produk</h4>

                </div>
                <div class="card-body">
                    <form action="{{route('admin.products-variant.update', $variant->id)}}" method="POST">
                        @csrf 
                        @method('PUT')
                            <div class="form-group">
                              <label>Nama</label>
                              <input type="text" name="name" class="form-control" value="{{$variant->nama}}">
                            </div>
                        
                            <div class="form-group">
                              <label>Status</label>
                              <select class="form-control" name="status">
                                <option {{$variant->status == 1 ? 'selected' : ''}} value="1">Aktif</option>
                                <option {{$variant->status == 0 ? 'selected' : ''}} value="0">Tidak Aktif</option>
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
