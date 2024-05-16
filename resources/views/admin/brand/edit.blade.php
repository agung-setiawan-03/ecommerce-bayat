@extends('admin.layouts.master');

@section('content')
      <!-- Main Content -->
      <section class="section">
        <div class="section-header">
          <h1>Merek</h1>

        </div>

        <div class="section-body">
      
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h4>Update Merek</h4>
                </div>
                <div class="card-body">
                    <form action="{{route('admin.brand.update', $brand->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="">Preview</label>
                            <br>
                            <img width="200" src="{{asset($brand->logo)}}" alt="">
                        </div>
                        <div class="form-group">
                            <label for="">Logo</label>
                            <input type="file" class="form-control" name="logo">
                        </div>
                        <div class="form-group">
                            <label for="">Nama</label>
                            <input type="text" class="form-control" name="name" value="{{$brand->nama}}">
                        </div>

                        <div class="form-group">
                            <label>Tampilkan Merek Di Frontend</label>
                            <select class="form-control" name="is_featured">
                              <option value="">Select</option>
                              <option {{$brand->di_tampilkan == 1 ? 'selected' : ''}} value="1">Iya</option>
                              <option {{$brand->di_tampilkan == 0 ? 'selected' : ''}} value="0">Tidak</option>

                            </select>
                          </div>

                        <div class="form-group">
                            <label for="inputState">Status</label>
                            <select id="inputState" class="form-control" name="status">
                                <option {{$brand->status == 1 ? 'selected' : ''}} value="1">Aktif</option>
                                <option {{$brand->status == 0 ? 'selected' : ''}} value="0">Tidak Aktif</option>
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