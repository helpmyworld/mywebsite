@extends('layouts.authorLayout.author_design')
@section('style')
  <link href="{{asset('/author/assets/libs/parsley/src/parsley.css')}}" rel="stylesheet" />
  @endsection
@section('content')
  <!-- ============================================================== -->
  <!-- Bread crumb and right sidebar toggle -->
  <!-- ============================================================== -->
  <div class="page-breadcrumb">
    <div class="row">
      <div class="col-12 d-flex no-block align-items-center">
        <h4 class="page-title">Create Product</h4>
        <div class="ml-auto text-right">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{route('author.dashboard')}}">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Create Product</li>
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
          <form class="form-horizontal" id="add-product-form" action="{{route('author.products.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="user_id" value="{{auth()->id()}}">
            <div class="card-body">
              <h4 class="card-title">Create Product</h4>
              <div class="form-group row">
                <label class="col-sm-3 text-right control-label col-form-label">Under Category</label>
                <div class="col-sm-9">
                  <select name="category_id" id="category_id" class="form-control" data-parsley-required="true">
                    <option value="" selected disabled="">---Select Category---</option>
                    @foreach($categories as $row)
                      <option value="{{$row->id}}">{{$row->name}}</option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div class="form-group row">
                 <label class="col-sm-3 text-right col-sm-3 text-right control-label col-form-label col-form-label">Product Type</label>
                <div class="col-sm-9">
                  <select name="product_type" id="product_type" style="width:220px;" class="form-control" data-parsley-required="true">
                    <option value="Physical Book">Physical Book</option>
                    <option value="ebook">Ebook</option>
                  </select>
                </div>
              </div>


              <div class="form-group row">
                <label class="col-sm-3 text-right col-sm-3 text-right control-label col-form-label col-form-label">Product Name</label>
                <div class="col-sm-9">
                  <input type="text" name="product_name" id="product_name" class="form-control" data-parsley-required="true">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-3 text-right control-label col-form-label">Author Name</label>
                <div class="col-sm-9">
                  <input type="text" name="product_author" id="product_author" class="form-control" data-parsley-required="true">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-3 text-right control-label col-form-label">ISBN Number</label>
                <div class="col-sm-9">
                  <input type="text" name="product_isbn" id="product_isbn" class="form-control" data-parsley-required="true">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-3 text-right control-label col-form-label">Product Code</label>
                <div class="col-sm-9">
                  <input type="text" name="product_code" id="product_code" class="form-control" data-parsley-required="true"> 
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-3 text-right control-label col-form-label" class="form-control">Product Color</label>
                <div class="col-sm-9">
                  <input type="text" name="product_color" id="product_color" class="form-control" data-parsley-required="true">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-3 text-right control-label col-form-label">Description</label>
                <div class="col-sm-9">
                  <textarea id="body" name="description" class="form-control message" ></textarea>

                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-3 text-right control-label col-form-label">Material & Care</label>
                <div class="col-sm-9">
                  <textarea id="body" name="care" class="form-control" data-parsley-required="true"></textarea>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-3 text-right control-label col-form-label">Price</label>
                <div class="col-sm-9">
                  <input type="text" name="price" id="price" class="form-control" data-parsley-required="true">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-3 text-right control-label col-form-label">Image</label>
                <div class="col-sm-9">
                  <input name="image" id="image" type="file" class="form-control"  data-parsley-max-file-size="3042" data-parsley-fileextension='jpg,png,jpeg'/>
                </div>
              </div>

              <div class="form-group row" id="book">
               <label class="col-sm-3 text-right control-label col-form-label">Upload Book</label>
                <div class="col-sm-9">
                  <div id="uniform-undefined"><input name="book"  type="file" id="upload-e-book" ><span class="filename">No file selected</span><span class="action">Choose File</span></div>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-3 text-right control-label col-form-label">Enable</label>
                <div class="col-sm-9">
                  <input type="checkbox" name="status" id="status" value="1" class="form-control">
                </div>
              </div>
              <div class="row ebook-hide">
                <label class="col-sm-3 text-right control-label col-form-label">Attribute</label>
                <div class="col-sm-9">
                  <div class="row" style="border-bottom: dotted 1px grey" align="center">
                    <div class="col-sm-3" style="border-right: dotted 1px grey">
                      <label>Size</label>
                    </div>
                    <div class="col-sm-3" style="border-right: dotted 1px grey">
                      <label>Price</label>
                    </div>
                    <div class="col-sm-3" style="border-right: dotted 1px grey">
                      <label>Stock</label>
                    </div>
                    <div class="col-sm-3" style="border-right: dotted 1px grey">
                      <label></label>
                    </div>
                  </div>
                </div>
              </div>
              <!--- end of headings -->
              <!--- Input Fields -->
              <div id="attribute-content">

              </div>
              <!--- / Input Fields -->
              <div class="row ebook-hide" style="margin-top: 10px">
                <div class="col-sm-3 offset-9">
                  <a href="javascript:;" id="add-attribute" class="btn btn-primary btn-block"><i class="fa fa-plus"></i> Add Attribute</a>
                </div>
              </div>
            </div>
            <div class="border-top">
              <div class="card-body">
                <button type="submit" class="btn btn-primary">Save</button>
              </div>
            </div>
          </form>
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

  <script src="{{ asset('/author/assets/libs/jquery/dist/jquery.min.js') }} "></script>
  <script src="{{ asset('/js/backend_js/bootstrap.min.js') }} "></script>
  <script src="{{ asset('/author/assets/libs/tinymce/tinymce.min.js') }} "></script>
  <script src="{{ asset('/author/assets/libs/parsley/dist/parsley.min.js') }} "></script>
  <script>

    $(".ebook-hide").show();
    $("#book").hide();

    $("#product_type").on('change', function(){
      if(this.value == 'ebook')
      {
        $(".ebook-hide").hide();
        $("#book").show();
        $("#upload-e-book").attr("data-parsley-required","true")
        $("#upload-e-book").attr("data-parsley-fileextension","pdf,doc,docx,ppt,xls,xlsx")
      }
      else
      {
        $(".ebook-hide").show();
        $("#upload-e-book").removeAttr("data-parsley-required")
        $("#upload-e-book").removeAttr("data-parsley-fileextension")
        $("#book").hide();
      }


    });

    window.Parsley.addValidator('maxFileSize', {
      validateString: function(_value, maxSize, parsleyInstance) {
        if (!window.FormData) {
          alert('You are making all developers in the world cringe. Upgrade your browser!');
          return true;
        }
        var files = parsleyInstance.$element[0].files;
        return files.length != 1  || files[0].size <= maxSize * 1024;
      },
      requirementType: 'integer',
      messages: {
        en: 'This file should not be larger than %s Kb',
        fr: 'Ce fichier est plus grand que %s Kb.'
      }
    });

    window.Parsley
            .addValidator('fileextension', function (value, requirement) {
              /* var fileExtension = value.split('.').pop();

               return fileExtension === requirement;*/
              var tagslistarr = requirement.split(',');
              var fileExtension = value.split('.').pop();
              var arr=[];
              $.each(tagslistarr,function(i,val){
                arr.push(val);
              });
              if(arr.indexOf(fileExtension) >= 0) {
                console.log("is in array");
                return true;
              } else {
                console.log("is NOT in array");
                return false;
              }
            }, 32)
            .addMessage('en', 'fileextension', 'The file format doesn\'t match the required');

    $('#add-product-form').parsley();

    //Add team form submission
    $('#add-attribute').on('click',function(){
      $('#attribute-content').append($('#team-form-content').text());

      //set click action on delete button
      $('.delete-attribute-form-row').on('click',function(){
        $(this).parent().parent().parent().parent().parent().remove();
      });
    });

    //Tiny mce config
    var editor_config = {
      setup: function (editor) {
        editor.on('change', function () {
          editor.save();
        });
      },
      path_absolute : "/",
      selector: ".message",
      theme: 'modern',
      width: '100%',
      height: 150,
      subfolder: '',
      content_css: '/author/assets/dist/css/style.min.css, /css/backend_css/bootstrap.min.css',
      relative_urls: false,
      convert_urls: false,
      link_list: [],
      external_plugins: {'nanospell': '/author/assets/libs/tinymce/plugins/spellchecker/plugin.js'},
      nanospell_server: 'php', // choose "php" "asp" "asp.net" or "java"
      nanospell_dictionary: "en",
      nanospell_autostart: true,
      nanospell_ignore_words_with_numerals: true,
      nanospell_ignore_block_caps: false,
      nanospell_compact_menu: false,
      toolbar: "nanospell",
      // replace with your images folder path
      plugins:
              [
                'advlist autolink link image lists charmap print preview hr anchor pagebreak',
                'searchreplace wordcount visualblocks visualchars code insertdatetime media nonbreaking',
                'table contextmenu directionality emoticons paste textcolor fullscreen openixemailtag'

              ],
      image_advtab: true,
      toolbar1: 'undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect | openixemailtag',
      toolbar2: 'forecolor backcolor | link unlink anchor | image media | preview code fullscreen | bootstrap ',

      file_browser_callback : function(field_name, url, type, win) {
        var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
        var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

        var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
        if (type == 'image') {
          cmsURL = cmsURL + "&type=Images";
        } else {
          cmsURL = cmsURL + "&type=Files";
        }

        tinyMCE.activeEditor.windowManager.open({
          file : cmsURL,
          title : 'Filemanager',
          width : x * 0.8,
          height : y * 0.8,
          resizable : "yes",
          close_previous : "no"
        });
      }
    };

    tinymce.init(editor_config);
  </script>
  <script id="team-form-content" type="text/template">
    <div class="row" style="margin-top: 10px">
      <div class="col-sm-3"></div>
      <div class="col-sm-9">
        <div  class="row">
          <div class="col-sm-12">
            <div class="row">
              <div class="col-sm-3" style="border-right: dotted 1px grey">
                <select name="size[]" data-parsley-required="true">
                  <option value="SMALL">SMALL</option>
                  <option value="MEDIUM">MEDIUM</option>
                  <option value="LARGE">LARGE</option>
                  <option value="A6 PaperBack">A6 PaperBack</option>
                  <option value="A5 PaperBack">A5 PaperBack</option>
                  <option value="Pocket Size">Pocket Size</option>
                  <option value="Paperback Square">Paperback Square</option>
                  <option value="SQUARE">SQUARE</option>
                </select>
              </div>
              <div class="col-sm-3" style="border-right: dotted 1px grey">
                <input type="text" name="price_a[]" class="form-control m-b-5" placeholder="Price" data-parsley-required="true">
              </div>
              <div class="col-sm-3" style="border-right: dotted 1px grey">
                <input type="text" name="stock[]" class="form-control m-b-5" placeholder="Stock" data-parsley-required="true">
              </div>
              <div class="col-md-3">
                <a href="javascript:;" class="delete-attribute-form-row"><i class="fa fa-trash"></i></a>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </script>
  @endsection