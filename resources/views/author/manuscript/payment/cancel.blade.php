@extends('layouts.authorLayout.author_design')

@section('content')

    <!-- begin #content -->
    <div id="content" class="content">
    @include('layouts.response')
    <!-- begin breadcrumb -->

        <div class="container-fluid">
            <!-- begin row -->
            <div class="row">
                <!-- begin col-2 -->

                <!-- end col-2 -->
                <!-- begin col-10 -->
                <div class="col-md-12">
                    <div class="note note-success note-with-right-icon" style="box-shadow: 2px 5px 2px #888888">
                        <div class="note-icon"><i class="fa fa-check-circle"></i></div>
                        <div class="note-content text-left">
                            <h4><b>Thank you.</b></h4>
                            <p> Your payment is cancelled.  </p>
                        </div>
                    </div>
                </div>


                <!-- end col-10 -->
            </div>
            <hr>
        </div>

        <!-- end row -->
    </div>
    <!-- end #content -->



@endsection
