@extends('admin.layouts.master');

@section('content')
      <!-- Main Content -->
      <section class="section">
        <div class="section-header">
          <h1>Kategori Induk</h1>

        </div>

        <div class="section-body">
      
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h4>Edit Kategori Induk</h4>

                </div>
                <div class="card-body">
                    <form action="{{route('admin.category.update', $category->id)}}" method="POST">
                        @csrf 
                        @method('PUT')
                        <div class="form-group">
                              <label class="">Icon</label>
                              <div>
                                <button class="btn btn-primary" data-arrow-class="btn-success"
                                data-selected-class="btn-danger"
                                data-unselected-class="btn-info" role="iconpicker" name="icon" data-icon="{{$category->icon}}"></button>
                              </div>
                              
                            </div>
                            <div class="form-group">
                              <label>Nama</label>
                              <input type="text" name="name" class="form-control" value="{{$category->nama}}">
                            </div>
                            <div class="form-group">
                              <label>Status</label>
                              <select class="form-control" name="status">
                                <option {{$category->status == 1 ? 'selected': ''}} value="1">Aktif</option>
                                <option {{$category->status == 0 ? 'selected': ''}} value="0">Tidak Aktif</option>
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
