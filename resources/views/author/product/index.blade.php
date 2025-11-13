@extends('layouts.authorLayout.author_design')
@section('content')
  <!-- ============================================================== -->
  <!-- Bread crumb and right sidebar toggle -->
  <!-- ============================================================== -->
  <div class="page-breadcrumb">
    <div class="row">
      <div class="col-12 d-flex no-block align-items-center">
        <h4 class="page-title">Product</h4>
        <div class="ml-auto text-right">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{route('author.dashboard')}}">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Product</li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </div>
  <!-- ============================================================== -->
  <!-- End Bread crumb and right sidebar toggle -->
  <!-- ============================================================== -->
  <!-- ============================================================== -->
  <!-- Container fluid  -->
  <!-- ============================================================== -->
  <div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Start Page Content -->
    <!-- ============================================================== -->
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            @include('layouts.response')
            <h5 class="card-title m-b-0">My Manuscripts</h5>
          </div>
          <table class="table">
            <thead>
            <tr>
              <th>Product ID</th>
              {{--<th>Category ID</th>--}}
              <th>Category Name</th>
              <th>Product Name</th>
              {{--<th>Product Code</th>--}}
              {{--<th>Product Color</th>--}}
              <th>Price</th>
              <th>Image</th>
              <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($products as $product)
              <tr>
                <td class="center">{{ $product->id }}</td>
                {{--<td class="center">{{ $product->category_id }}</td>--}}
                <td class="center">{{ $product->category_name }}</td>
                <td class="center">{{ $product->product_name }}</td>
                {{--<td class="center">{{ $product->product_code }}</td>--}}
                {{--<td class="center">{{ $product->product_color }}</td>--}}
                <td class="center">{{ $product->price }}</td>
                <td class="center">
                  @if(!empty($product->image))
                    <img src="{{ asset('/images/backend_images/product/small/'.$product->image) }}" style="width:50px;">
                  @endif
                </td>
                <td>
                  <a  href="javascript:;" data-id="{{$product->id}}"  class="btn btn-success view" >View</a>
                  <a href="{{route('author.products.edit',['product' => $product->id])}}" class="btn btn-success">Edit</a>
                  <a href="{{route('author.product.orders.index',['product_id' => $product->id])}}" title="View orders on this product" class="btn btn-success">Manage Orders</a>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>

      </div>
    </div>
    <!-- ============================================================== -->
    <!-- End PAge Content -->
    <!-- ============================================================== -->

  </div>
  <!-- ============================================================== -->
  <!-- End Container fluid  -->
  <!-- ============================================================== -->

  <div class="modal fade" id="viewProductModal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Product View</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">�</button>
        </div>
        <div class="modal-body">
          <p><b>Product ID:</b>> <span id="product-id"></span></p>
          <p><b>Category ID:</b> <span id="category-id"></span></p>
          <p><b>Product Code:</b> <span id="product-code"></span></p>
          <p><b>Product Color:</b> <span id="product-color"></span></p>
          <p><b>Price:</b> <span id="product-price"></span></p>
          <p><b>Description:</b> <br><span id="desc"></span></p></p>
        </div>
        <div class="modal-footer">
          <a href="javascript:;" class="btn btn-white" id="delete-user" data-dismiss="modal">Close</a>
        </div>
      </div>
    </div>
  </div>

  <script src="{{ asset('/js/backend_js/jquery.min.js') }} "></script>
  <script src="{{ asset('/js/backend_js/bootstrap.min.js') }} "></script>
  <script>

    $('.view').on('click',function(){
      var product_id = $(this).data('id');
      $.ajax("/author/products/"+product_id,{
        type : 'get',
        dataType : 'json',
        data : {},
        success : function (res) {
          console.log(res);
          $('#product-id').text(res.id);
          $('#category-id').text(res.category_id);
          $('#product-code').text(res.product_code);
          $('#product-color').text(res.product_color);
          $('#product-price').text(res.price);
          $('#desc').html(res.description);

          $('#viewProductModal').modal('show');
        }
        
      });
    });

  </script>

  @endsection