@extends('layouts.adminLayout.admin_design')

@section('content')

    <link rel="stylesheet" href="/public/css/select2.min.css">
    <link rel="stylesheet" href="/public/css/parsley.css">

    {!! Html::style('css/parsley.css') !!}
    {!! Html::style('css/select2.min.css') !!}
    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>

    <script>
        tinymce.init({
            selector: 'textarea',
            plugins: 'link code',
            menubar: false,
            theme: "modern",
            height: 300,
            plugins: [
                'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                'searchreplace wordcount visualblocks visualchars code fullscreen',
                'insertdatetime media nonbreaking save table contextmenu directionality',
                'emoticons template paste textcolor colorpicker textpattern imagetools'
            ],
            toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
            toolbar2: 'print preview media | forecolor backcolor emoticons',
            image_advtab: true
        });
        tinymce.suffix = ".min";
        tinyMCE.baseURL = '{{ asset('/assets/backend/plugins/tinymce') }}';
    </script>

    <div id="content">
        <div id="content-header">
            <div id="breadcrumb">
                <a href="index.html" title="Go to Home" class="tip-bottom">
                    <i class="icon-home"></i> Home
                </a> 
                <a href="#">Products</a> 
                <a href="#" class="current">Edit Product</a>
            </div>
            <h1>Products</h1>
            @if(Session::has('flash_message_error'))
                <div class="alert alert-error alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{!! session('flash_message_error') !!}</strong>
                </div>
            @endif
            @if(Session::has('flash_message_success'))
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{!! session('flash_message_success') !!}</strong>
                </div>
            @endif
        </div>
        <div class="container-fluid">
            <hr>
            <div class="row-fluid">
                <div class="span12">
                    <div class="widget-box">
                        <div class="widget-title">
                            <span class="icon"> <i class="icon-info-sign"></i> </span>
                            <h5>Edit Product</h5>
                        </div>
                        <div class="widget-content nopadding">
                            <form enctype="multipart/form-data" class="form-horizontal" method="post"
                                  action="{{ url('admin/edit-product/'.$productDetails->id) }}" name="edit_product"
                                  id="edit_product" novalidate="novalidate">
                                {{ csrf_field() }}

                                <div class="control-group">
                                    <label class="control-label">Under Category</label>
                                    <div class="controls">
                                        <select name="category_id" id="category_id" style="width:220px;">
                                            {!! $categories_drop_down !!}
                                        </select>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Product Name</label>
                                    <div class="controls">
                                        <input type="text" name="product_name" id="product_name"
                                               value="{{ $productDetails->product_name }}">
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Author Name</label>
                                    <div class="controls">
                                        <input type="text" name="product_author" id="product_author"
                                               value="{{ $productDetails->product_author }}">
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">ISBN Number</label>
                                    <div class="controls">
                                        <input type="text" name="product_isbn" id="product_isbn"
                                               value="{{ $productDetails->product_isbn }}">
                                    </div>
                                </div>

                               
                                <div class="control-group">
                                    <label class="control-label">Description</label>
                                    <div class="controls">
                                        <textarea name="description">{{ $productDetails->description }}</textarea>
                                    </div>
                                </div>

                                

                                <div class="control-group">
                                    <label class="control-label">Price</label>
                                    <div class="controls">
                                        <input type="text" name="price" id="price"
                                               value="{{ $productDetails->price }}">
                                    </div>
                                </div>

                                                                <div class="control-group">
                                <label class="control-label">Royalty Rate (%)</label>
                                <div class="controls">
                                    <input type="number" step="0.01" min="0" max="100" name="royalty_rate"
                                        value="{{ old('royalty_rate', $productDetails->royalty_rate) }}">
                                    <span class="help-block">Leave empty to use the default rate.</span>
                                </div>
                                </div>


                                <div class="control-group">
                                    <label class="control-label">Image</label>
                                    <div class="controls">
                                        <input name="image" id="image" type="file">
                                        @if(!empty($productDetails->image))
                                            <input type="hidden" name="current_image"
                                                   value="{{ $productDetails->image }}">
                                            <img style="width:30px;"
                                                 src="{{ asset('/images/backend_images/product/small/'.$productDetails->image) }}">
                                            |
                                            <a href="{{ url('/admin/delete-product-image/'.$productDetails->id) }}">Delete</a>
                                        @endif
                                    </div>
                                </div>

                                @if($productDetails->type == "ebook")
                                <div class="control-group">
                                    <label class="control-label">Ebook</label>
                                    <div class="controls">
                                        <input name="ebook" id="ebook" type="file">
                                        @if(!empty($productDetails->book_path))
                                            <input type="hidden" name="current_ebook"
                                                   value="{{ $productDetails->book_path }}">
                                            <a title="View Book" target="_blank" 
                                               href="https://helpmyworld.s3-eu-west-1.amazonaws.com/uploads/ebooks/{{$productDetails->book_path}}">
                                               <span class="icon icon-file-alt icon-4x"></span>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                                @else
                                    @if(!empty($productDetails->book_path))
                                        <input type="hidden" name="current_ebook"
                                               value="{{ $productDetails->book_path }}">
                                    @endif
                                @endif

                                <!-- Preview PDF Upload -->
                                <div class="control-group">
                                    <label class="control-label">Preview PDF</label>
                                    <div class="controls">
                                        <input type="file" name="preview_file" class="form-control">
                                       @if(!empty($productDetails->preview_file))
    @php
        $hash = Crypt::encryptString($productDetails->preview_file);
    @endphp
    <a href="{{ route('admin.preview.file', ['hash' => urlencode($hash)]) }}"
       target="_blank" class="btn btn-info" style="margin-top:8px;">
        View current preview
    </a>
@endif

                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Enable</label>
                                    <div class="controls">
                                        <input type="checkbox" name="status" id="status"
                                               @if($productDetails->status == "1") checked @endif value="1">
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Feature Item</label>
                                    <div class="controls">
                                        <input type="checkbox" name="feature_item" id="feature_item"
                                               @if($productDetails->feature_item == "1") checked @endif value="1">
                                    </div>
                                </div>



                                <div class="control-group">
  <label class="control-label">Product Flags</label>
  <div class="controls">
    <label style="display:inline-block;margin-right:12px;">
      <input type="checkbox" name="is_featured" value="1" {{ !empty($productDetails->is_featured) ? 'checked' : '' }}> Featured
    </label>
    <label style="display:inline-block;margin-right:12px;">
      <input type="checkbox" name="is_new_arrival" value="1" {{ !empty($productDetails->is_new_arrival) ? 'checked' : '' }}> New Arrival
    </label>
    <label style="display:inline-block;margin-right:12px;">
                  <input type="checkbox" name="is_special_offer" value="1" {{ !empty($productDetails->is_special_offer) ? 'checked' : '' }}> Special Offer
                </label>
    <label style="display:inline-block;margin-right:12px;">
      <input type="checkbox" name="is_best_seller" value="1" {{ !empty($productDetails->is_best_seller) ? 'checked' : '' }}> Best Seller
    </label>
  </div>
</div>


                                <div class="form-actions">
                                    <input type="submit" value="Edit Product" class="btn btn-success">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
