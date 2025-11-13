@extends('layouts.authorLayout.author_design')
@section('content')
  <!-- ============================================================== -->
  <!-- Bread crumb and right sidebar toggle -->
  <!-- ============================================================== -->
  <div class="page-breadcrumb">
    <div class="row">
      <div class="col-12 d-flex no-block align-items-center">
        <h4 class="page-title">Post a blog</h4>
        <div class="ml-auto text-right">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{route('author.dashboard')}}">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Ask a question</li>
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
          @include('layouts.response')
          <form class="form-horizontal" action="{{route('author.blogs.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="user_id" value="{{auth()->id()}}">
            <div class="card-body">
              <h4 class="card-title">Post a question</h4>
              <div class="form-group row">
                <label for="title" class="col-sm-3 text-right control-label col-form-label">Title</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}" id="title" name="title" placeholder="Enter Title" required value="{{old('title')}}">
                  @if ($errors->has('title'))
                    <span class="invalid-feedback">
                                              <strong>{{ $errors->first('title') }} </strong>
                                            </span>
                  @endif
                </div>
              </div>

              <div class="form-group row">
                <label for="title" class="col-sm-3 text-right control-label col-form-label">File upload Image</label>
                <div class="col-sm-9">
                  <input type ="file" name="image" id="image" class="form-control"  multiple="multiple">
                  @if ($errors->has('image'))
                    <span class="invalid-feedback">
                                              <strong>{{ $errors->first('image') }} </strong>
                                            </span>
                  @endif
                </div>
              </div>
              <div class="form-group row">
                <label for="title" class="col-sm-3 text-right control-label col-form-label">Categories</label>
                  <div class="col-md-9">
                    <select class="form-control select2-multi" id="cats" name="cats"  multiple="multiple">
                      @foreach($cats as $cat)
                        <option value="{{$cat->id}}">{{$cat->name}}</option>
                      @endforeach
                    </select>
                    @if($errors->has('cats'))
                      <span class="help-block">
                                                    <strong>{{$errors->first('cats')}}</strong>
                                                </span>
                    @endif
                  </div>
              </div>
              <div class="form-group row">
                <label for="title" class="col-sm-3 text-right control-label col-form-label">Content</label>
                <div class="col-sm-9">
                  <textarea  class="form-control message {{ $errors->has('body') ? ' is-invalid' : '' }}" id="title" name="body" placeholder="Enter Content" required >{{old('body')}}</textarea>
                  @if ($errors->has('body'))
                    <span class="invalid-feedback">
                                              <strong>{{ $errors->first('body') }} </strong>
                                            </span>
                  @endif
                </div>
              </div>
            </div>
            <div class="border-top">
              <div class="card-body">
                <button type="submit" class="btn btn-primary">Post</button>
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


  <script src="{{ asset('/js/backend_js/jquery.min.js') }} "></script>
  <script src="{{ asset('/js/backend_js/bootstrap.min.js') }} "></script>
  <script src="{{ asset('/author/assets/libs/tinymce/tinymce.min.js') }} "></script>
  <script>
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
  @endsection