@extends('layouts.adminLayout.admin_design')

@section('stylesheets')

    {!! Html::style('css/parsley.css') !!}
    {!! Html::style('css/select2.min.css') !!}

@endsection


@section('content')

  <div id="content">
    <div id="content-header">
      <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">CMS Pages</a> <a href="#" class="current">Edit CMS Page</a> </div>
      <h1>CMS Pages</h1>
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
            <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
              <h5>Edit CMS Page</h5>
            </div>
            <div class="widget-content nopediting">
              <form enctype="multipart/form-data" class="form-horizontal" method="post" action="{{ url('admin/edit-cms-page/'.$cmsPage->id) }}"
                    name="edit-cms-page" id="edit-cms-page" novalidate="novalidate">{{ csrf_field() }}

                <div class="control-group">
                  <label class="control-label">Title</label>
                  <div class="controls">
                    <input type="text" name="title" id="title" value="{{ $cmsPage->title }}">
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">CMS Page URL</label>
                  <div class="controls">
                    <input type="text" name="url" id="url" value="{{ $cmsPage->url }}">
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">Description</label>
                  <div class="controls">
                    <textarea id="body" name="description" class="message">{{ $cmsPage->description }}</textarea>

                  </div>
                </div>

                <div class="control-group">
                  <label class="control-label">Enable</label>
                  <div class="controls">
                    <input type="checkbox" name="status" id="status" @if( $cmsPage->status == "1" ) checked @endif value="1">
                  </div>
                </div>
                <div class="form-actions">
                  <input type="submit" value="edit CMS Page" class="btn btn-success">
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection

@section ('scripts')

    <script src="/js/parsley.min.js"></script>
    <script src="/js/select2.min.js"></script>
    <script src="{{ asset('/js/backend_js/bootstrap.min.js') }} "></script>
    <script src="{{ asset('/author/assets/libs/tinymce/tinymce.min.js') }} "></script>

    <script type="text/javascript">
        $('.select2-multi').select2();
    </script>

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

