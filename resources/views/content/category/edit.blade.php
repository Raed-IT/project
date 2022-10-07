@extends('layouts/contentNavbarLayout')

@section('title', 'الفئات')

@section('content')
    @if ($errors->any())
        <div class="col-12 col-sm-12 col-md-6 ">

            @foreach ($errors->all() as $error)
                <div class="alert alert-danger" role="alert">
                    {{ $error }}
                </div>
            @endforeach

        </div>
    @endif
    <div class="col-12 col-sm-12 col-md-6">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Update Category</h5> <small class="text-muted float-end">create new Category</small>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('category-update', $category->id) }}" enctype="multipart/form-data">
                    <input name="_token" type="hidden" value="{{ csrf_token() }}" />
                    <div class="mb-3">
                        <label class="form-label" for="basic-default-fullname">Category Name</label>
                        <input name="name" type="text" value="{{ $category->name }}" class="form-control"
                            id="basic-default-fullname" placeholder="category name" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="basic-default-message">Category Descriuption </label>
                        <textarea id="basic-default-message" name="desc" class="form-control" placeholder=" type Category Descriuption">{{ $category->desc }}</textarea>
                    </div>
                    @if ($category->images()->first())
                        <img src="{{ URL::asset('images/' . $category->images->first()->url) }}" alt="cddf"
                            max-height="200" width="80%">
                    @endif
                    <div class="mb-3">
                        <div class="input-group">

                            <input type="file" name="image" class="form-control" id="inputGroupFile01">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
@endsection
