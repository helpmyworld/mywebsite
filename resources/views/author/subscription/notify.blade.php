@extends('layouts.authorLayout.author_design')

@section('css')
    @include('layouts.admin_css.home_css')
@endsection

@section('content')

    <!-- begin #content -->
    <div id="content" class="content">
    @include('layouts.alert.response')
    <!-- begin breadcrumb -->

        <!-- begin row -->
        <div class="row">
            <!-- begin col-2 -->

            <!-- end col-2 -->
            <!-- begin col-10 -->
            <div class="col-lg-12">
              Redirecting...
            </div>
            <!-- end col-10 -->
        </div>
        <!-- end row -->
    </div>
    <!-- end #content -->



@endsection

@section('script')
    @include('layouts.admin_script.table_script')
    <script>




    </script>
@endsection