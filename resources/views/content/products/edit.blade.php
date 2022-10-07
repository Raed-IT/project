@extends('layouts/contentNavbarLayout')

@section('title', 'اضافه منتج ')

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
                <h5 class="mb-0">UIpdate Product</h5> <small class="text-muted float-end">Update Product </small>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('product-update', $product->id) }}" enctype="multipart/form-data">
                    <input name="_token" type="hidden" value="{{ csrf_token() }}" />
                    <div class="mb-3">
                        <label class="form-label" for="basic-default-fullname">Product Name</label>
                        <input required name="name" value="{{ $product->name }}" type="text" class="form-control"
                            id="basic-default-fullname" placeholder="Product name" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="basic-default-message">Product price </label>
                        <input required name="price" value="{{ $product->price }}" type="number" class="form-control"
                            id="basic-default-fullname" placeholder="Product name" />
                    </div>
                    <div class="mb-3">
                        <label for="defaultSelect" class="form-label">Category</label>
                        <select id="defaultSelect" name="category_id" class="form-select">
                            <option>select category</option>
                            @foreach ($category as $cat)
                                @if ($product->category_id == $cat->id)
                                    <option selected value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @else
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="basic-default-message">Product Descriuption </label>
                        <textarea id="basic-default-message" name="desc" class="form-control" placeholder=" type Category Descriuption">{{ $product->desc }}</textarea>
                    </div>
                    @if ($product->images->first())
                        <img src="{{ URL::asset('images/' . $product->images->first()->url) }}" alt="cddf"
                            max-height="200" width="80%">
                    @endif
                    <div class="mb-3">
                        <div class="input-group">

                            <input type="file" name="image" class="form-control" id="inputGroupFile01">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">update</button>
                </form>
            </div>
        </div>
    </div>
@endsection
