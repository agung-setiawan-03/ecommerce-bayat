@extends('admin.layouts.master');

@section('content')
    <!-- Main Content -->
    <section class="section">
        <div class="section-header">
            <h1>Kategori Anak</h1>

        </div>

        <div class="section-body">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Update Kategori Anak</h4>

                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.child-category.update',$childCategory->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label>Kategori Induk</label>
                                    <select class="form-control main-category" name="category">
                                        <option value="">Select</option>
                                        @foreach ($categories as $category)
                                            <option {{$category->id == $childCategory->kategori_id ? 'selected' : ''}} value="{{ $category->id }}">{{ $category->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Sub Kategori</label>
                                    <select class="form-control sub-category" name="sub_category">
                                      @foreach ($subCategories as $subCategory)
                                      <option {{$subCategory->id == $childCategory->sub_kategori_id ? 'selected' : ''}} value="{{$subCategory->id}}">{{$subCategory->nama}}</option>
                                      @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" name="name" class="form-control" value="{{$childCategory->nama}}">
                                </div>
                                <div class="form-group">
                                    <label>Status</label>
                                    <select class="form-control" name="status">
                                      <option {{$childCategory->status == 1 ? 'selected' : ''}} value="1">Aktif</option>
                                      <option {{$childCategory->status == 0 ? 'selected' : ''}} value="0">Tidak Aktif</option>
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

@push('scripts')
    <script>
        $(document).ready(function() {
            $('body').on('change', '.main-category', function(e) {
                let id = $(this).val();
                $.ajax({
                    method: 'GET',
                    url: "{{ route('admin.get-subcategories') }}",
                    data: {
                        id: id
                    },
                    success: function(data) {
                        $('.sub-category').html('<option value="">Select</option>')

                        $.each(data, function(i, item) {

                            $('.sub-category').append(
                                `<option value="${item.id}">${item.nama}</option>`)

                        })
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    }
                })
            })
        })
    </script>
@endpush
