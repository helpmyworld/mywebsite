@extends('layouts.authorLayout.author_design')
@section('content')

    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Manuscript</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('author.dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Manuscript</li>
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
                        <h5 class="card-title m-b-0">Manuscript Detail</h5>
                    </div>
                    <div class="card-body">
                        <div class="widget-box">
                            <div class="widget-content nopadding">
                                <form  class="form-horizontal" >
                                    <div class="control-group">
                                        <label class="control-label"><b>Title :</b> </label>
                                        <label class="control-label">{{ $manuscript->title }}</label>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label"><b>Progress :</b> </label>
                                        <label class="control-label text-success">{{ $manuscript->status }}</label>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label"><b>Uploaded By :</b> </label>
                                        <label class="control-label">{{ $manuscript->user->name }}</label>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label"><b>Uploaded At :</b> </label>
                                        <label class="control-label">{{ $manuscript->created_at }}</label>
                                    </div>
                                    @if($manuscript->accepted_comment)
                                        <div class="control-group">
                                            <label class="control-label"><b>Accepted Comment:</b> </label>
                                            <label class="control-label">{{ $manuscript->accepted_comment }}</label>
                                        </div>
                                    @endif
                                    @if($manuscript->rejected_comment)
                                        <div class="control-group">
                                            <label class="control-label"><b>Rejected Comment:</b> </label>
                                            <label class="control-label">{{ $manuscript->rejected_comment }}</label>
                                        </div>
                                    @endif
                                    <p>*Subscribers will have to choose one package as a method of payment for publishing*</p>


                                    @if($manuscript->status == 'Accepted')

                                        @if(auth()->user()->active_subscription())

                                            @else
                                            <div class="form-actions">
                                                <a href="{{route('author.manuscript.payments.show',['id' => $manuscript->id])}}"  class="btn btn-success"> Pay</a>
                                                <a href="{{route('author.subscriptions.browse')}}"  class="btn btn-success"> Subscribe</a>
                                            </div>
                                        @endif

                                    @endif


                                </form>
                            </div>
                        </div>
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
<script>

</script>

@endsection

