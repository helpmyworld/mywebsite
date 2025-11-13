@extends('layouts.frontLayout.front_design')

@section('content')

    <div id="contact-page" class="container">
        <div class="bg">
                <div class="row">
                    <div class="col-sm-12">
                        <h2 class="title text-center">Shipping-information</h2>

                    </div>
                </div>


                <div class="row">
                <div class="col-sm-6 col-sm-offset-2">
                    <h3>Shipping Info</h3>

                    {!! Form::open(['route' => 'address.store', 'method' => 'post']) !!}

                    <div class="form-group">
                        {{ Form::label('addressline', 'Address Line') }}
                        {{ Form::text('addressline', null, array('class' => 'form-control')) }}
                    </div>

                    <div class="form-group">
                        {{ Form::label('city', 'City') }}
                        {{ Form::text('city', null, array('class' => 'form-control')) }}
                    </div>
                    <div class="form-group">
                        {{ Form::label('state', 'State') }}
                        {{ Form::text('state', null, array('class' => 'form-control')) }}
                    </div>
                    <div class="form-group">
                        {{ Form::label('zip', 'Zip') }}
                        {{ Form::text('zip', null, array('class' => 'form-control')) }}
                    </div>
                    <div class="form-group">
                        {{ Form::label('country', 'Country') }}
                        {{ Form::text('country', null, array('class' => 'form-control')) }}
                    </div>
                    <div class="form-group">
                        {{ Form::label('phone', 'Phone') }}
                        {{ Form::text('phone', null, array('class' => 'form-control')) }}
                    </div>

                    {{ Form::submit('Proceed to Payment', array('class' => 'btn btn-success')) }}
                    {!! Form::close() !!}

                    </br>
                    </br>
                    </br>
                    </br>
                </div>


    </div>
        </div>
    </div>

@endsection
