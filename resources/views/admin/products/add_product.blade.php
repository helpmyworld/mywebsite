@extends('layouts.adminLayout.admin_design')

@section('stylesheets')
  {!! Html::style('/css/parsley.css') !!}
  {!! Html::style('/css/select2.min.css') !!}

  {{-- Load ONE TinyMCE (v6) --}}
  <script src="https://cdn.tiny.cloud/1/hkeugakcjabj5i5crwz4uwobvp2y9eca01mgcihlc4227utv/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      tinymce.init({
        selector: 'textarea',
        menubar: false,
        height: 300,
        plugins: 'advlist autolink lists link image charmap preview anchor ' +
                 'searchreplace visualblocks code fullscreen ' +
                 'insertdatetime media table help wordcount',
        toolbar: 'undo redo | blocks | bold italic underline | ' +
                 'alignleft aligncenter alignright alignjustify | ' +
                 'bullist numlist outdent indent | link image | removeformat | code | help',
        branding: false
      });
    });
  </script>

  <script src="https://cdn.tiny.cloud/1/hkeugakcjabj5i5crwz4uwobvp2y9eca01mgcihlc4227utv/tinymce/8/tinymce.min.js" referrerpolicy="origin" crossorigin="anonymous"></script>

    <script>
      tinymce.init({
        selector: 'textarea'
      });
    </script>



@endsection

@section('content')
<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
      <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a>
      <a href="#">Products</a>
      <a href="#" class="current">Add Product</a>
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

  <div class="container-fluid"><hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"><span class="icon"><i class="icon-info-sign"></i></span><h5>Add Product</h5></div>

          <div class="widget-content nopadding">
            <form enctype="multipart/form-data" class="form-horizontal" method="post"
                  action="{{ url('admin/add-product') }}" name="add_product" id="add_product" novalidate="novalidate">
              {{ csrf_field() }}

              <div class="control-group">
                <label class="control-label">Under Category</label>
                <div class="controls">
                  <select name="category_id" id="category_id" style="width:220px;">
                    <?php echo $categories_drop_down; ?>
                  </select>
                </div>
              </div>

              <div class="control-group">
                <label class="control-label">Product Type</label>
                <div class="controls">
                  <select name="product_type" id="product_type" style="width:220px;">
                    <option value="Physical Book">Physical Book</option>
                    <option value="ebook">Ebook</option>
                  </select>
                  <span class="help-block" style="margin-top:6px;">
                    This controls shipping/checkout rules. You can still upload an eBook PDF and a short preview below regardless of the selected type.
                  </span>
                </div>
              </div>

              <div class="control-group">
                <label class="control-label">Product Name</label>
                <div class="controls">
                  <input type="text" name="product_name" id="product_name">
                </div>
              </div>

              <div class="control-group">
                <label class="control-label">Author Name</label>
                <div class="controls">
                  <input type="text" name="product_author" id="product_author">
                </div>
              </div>

              <div class="control-group">
                <label class="control-label">ISBN Number</label>
                <div class="controls">
                  <input type="text" name="product_isbn" id="product_isbn">
                </div>
              </div>

              

              

              <div class="control-group">
                <label class="control-label">Description</label>
                <div class="controls">
                  <textarea id="body" name="description"></textarea>
                </div>
              </div>

              

              <div class="control-group">
                <label class="control-label">Price</label>
                <div class="controls">
                  <input type="text" name="price" id="price">
                </div>
              </div>


              <div class="control-group">
                <label class="control-label">Royalty Rate (%)</label>
                <div class="controls">
                  <input type="number" step="0.01" min="0" max="100" name="royalty_rate" placeholder="e.g. 30">
                  <span class="help-block">Leave empty to use the default rate.</span>
                </div>
              </div>


              <div class="control-group">
                <label class="control-label">Cover Image</label>
                <div class="controls">
                  <div class="uploader" id="uniform-undefined">
                    <input name="image" id="image" type="file" size="19" accept="image/*" style="opacity: 0;">
                    <span class="filename">No file selected</span><span class="action">Choose File</span>
                  </div>
                </div>
              </div>

              {{-- Always allow uploading full Ebook (PDF) --}}
              <div class="control-group" id="ebook_upload">
                <label class="control-label">Ebook (Full PDF)</label>
                <div class="controls">
                  <div class="uploader" id="uniform-undefined">
                    <input name="book" id="book" type="file" size="19" accept="application/pdf" style="opacity: 0;">
                    <span class="filename">No file selected</span><span class="action">Choose File</span>
                  </div>
                  <span class="help-block" style="margin-top:6px;">
                    Optional. If provided, the file is stored on S3. A short preview PDF will be auto-generated.
                  </span>
                </div>
              </div>

              {{-- Optional Preview PDF (we still trim it server-side) --}}
              <div class="control-group" id="preview_upload">
                <label class="control-label">Preview PDF (optional)</label>
                <div class="controls">
                  <div class="uploader" id="uniform-undefined">
                    <input name="preview_file" id="preview_file" type="file" size="19" accept="application/pdf" style="opacity: 0;">
                    <span class="filename">No file selected</span><span class="action">Choose File</span>
                  </div>
                  <span class="help-block" style="margin-top:6px;">
                    Optional. If provided, only the first {{ config('preview.pages', 10) }} pages are kept for the public sample.
                  </span>
                </div>
              </div>

              <div class="control-group">
                <label class="control-label">Enable</label>
                <div class="controls">
                  <input type="checkbox" name="status" id="status" value="1">
                </div>
              </div>

              <div class="control-group">
                <label class="control-label">Feature Item</label>
                <div class="controls">
                  <input type="checkbox" name="feature_item" id="feature_item" value="1">
                </div>
              </div>



                          <div class="control-group">
              <label class="control-label">Product Flags</label>
              <div class="controls">
                <label style="display:inline-block;margin-right:12px;">
                  <input type="checkbox" name="is_featured" value="1"> Featured
                </label>
                <label style="display:inline-block;margin-right:12px;">
                  <input type="checkbox" name="is_new_arrival" value="1"> New Arrival
                </label>
                <label style="display:inline-block;margin-right:12px;">
                  <input type="checkbox" name="is_special_offer" value="1"> Special Offer
                </label>
                <label style="display:inline-block;margin-right:12px;">
                  <input type="checkbox" name="is_best_seller" value="1"> Best Seller
                </label>
              </div>
            </div>


              <div class="form-actions">
                <input type="submit" value="Add Product" class="btn btn-success">
              </div>
            </form>
          </div> <!-- /.widget-content -->
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
  <script src="/js/query-3.2.1.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="/js/parsley.min.js"></script>
  <script src="/js/select2.min.js"></script>
  <script>
    $('.select2-multi').select2();

    // Optional: just adjust the hint per type (don’t hide anything).
    (function(){
      function hintByType(){
        var type = document.getElementById('product_type').value;
        document.querySelector('#ebook_upload .help-block').innerHTML =
          type === 'ebook'
            ? 'For eBooks, upload the full PDF here (stored on S3). A short preview will be auto-generated.'
            : 'Optional. Physical books can also include an eBook PDF for digital delivery; a short preview will be generated.';
      }
      $('#product_type').on('change', hintByType);
      hintByType();
    })();
  </script>
@endsection
