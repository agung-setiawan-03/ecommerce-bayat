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
                  <h4>Buat Varian Produk</h4>

                </div>
                <div class="card-body">
                    <form action="{{route('admin.products-variant.store')}}" method="POST">
                        @csrf 

                            <div class="form-group">
                              <label>Nama</label>
                              <input type="text" name="name" class="form-control" value="">
                            </div>
                            
                            <div class="form-group">
                                <input type="hidden" name="product" class="form-control" value="{{request()->product}}">
                              </div>

                            <div class="form-group">
                              <label>Status</label>
                              <select class="form-control" name="status">
                                <option value="1">Aktif</option>
                                <option value="0">Tidak Aktif</option>
                              </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Create</button>
                      </form>
                </div>

              </div>
            </div>
          </div>

        </div>
      </section>
    
@endsection
