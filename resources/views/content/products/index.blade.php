@extends('layouts/contentNavbarLayout')
@section('page-script')
    <script src="{{ asset('assets/js/ui-modals.js') }}"></script>
@endsection

@section('title', 'المنتجات')





@section('content')
    <!-- Basic Bootstrap Table -->
    <div class="card">
        <h5 class="card-header">Table Basic</h5>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Name </th>
                        <th>Description</th>
                        <th>image</th>
                        <th>price</th>
                        <th>category</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach ($products as $product)
                        <tr>
                            <td><i class="fab fa-angular fa-lg text-danger me-3"></i> {{ $product->name }}</td>
                            <td>{{ $product->desc }}</td>
                            <td>

                                @if ($product->images->first())
                                    <img src="{{ URL::asset('images/' . $product->images->first()->url) }}" alt="cddf"
                                        height="100" width="100">
                                @else
                                    no Image
                                @endif

                            </td>
                            <td>
                                {{ $product->price }}
                            </td>
                            <td>
                                {{ $product->category->name }}
                            </td>
                            <td>
                                <!-- Vertically Centered Modal -->
                                <div class="col-lg-4 col-md-6">
                                    <div class="mt-3">
                                        <!-- Button trigger modal -->
                                        <a href="{{ route('product-edit', $product->id) }}">
                                            <img style="cursor: pointer "
                                                src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAAAXNSR0IArs4c6QAAAP1JREFUSEvlldERwiAQRF8qUCtQO7AErcASHDuwIy3BDrQE7UA7sAOddSCDZzBAki/5yWSAfbd3B1QMPKqB9ekTcADOgL71sIAlsAdmLc62RkiiG7fnY84CbsA0U1zBXIBRsK+GWMDTLUpNncQV1MKlx0N6ASgta2DlHHjILkxfqYMw548AMgb0Hy1ySopCcS8k0bkV12SugyZx6diuKnKQKq5aqKveI9VBjvgJmOQAUsWlqVqoVevAUxz4wofNEcv5V5OUAKIFBToDfonLYREg50b/A4Bvs5y02LVXd7s2HjQ9OOr7tjchFsAd0G16jB20LpE37k19WIrBgwNed7ZCGbKlO0wAAAAASUVORK5CYII=" />
                                        </a>
                                        <img style="cursor: pointer" data-bs-toggle="modal" data-bs-target="#modalCenter"
                                            src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAAAXNSR0IArs4c6QAAAKlJREFUSEvtlcERQDAQRZ9KlIBOlEIFlKQUOqASJjM4hJ0fIje5ZTbZ9//uJJuReGWJ86MANdABpSFkBlpgsIQqgEuQC5cjUL0FrPtFS4iKyxKpBCp+ARwXYnt/OvatJwccyqV1z6J5/nXzvgb4CtX+5Ic6UAmjS/QDLu/qaUn+HsivKbpEivAYEDJofOh0N/msl+xGZQ8USvoeX4DmbnSqkRmY3z6WHLABUDk4GfuOp84AAAAASUVORK5CYII=" />
                                        <!--Delete  Modal -->
                                        <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
                                            <form method="post" action="/admin/products/destroy/{{ $product->id }}">
                                                @method('delete')
                                                @csrf
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="modalCenterTitle">Delete Product
                                                            </h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="modalCenterTitle">
                                                                {{ $product->name }}
                                                            </h5>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-outline-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                            <button value="Delete" type="submet"
                                                                class="btn btn-danger">delete</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!--/ Basic Bootstrap Table -->

@endsection
