@extends('layouts.frontLayout.front_design')

@section('content')
    <div id="contact-page" class="container">
        <div class="bg">
            <div class="row">
                <div class="col-sm-12">
                    <h2 class="title text-center">Special &nbsp; <strong>Promotion</strong></h2>

                </div>
            </div>
            <div class="w3ls_about_grids">
                <div class="col-md-6 w3ls_about_grid_left">
                    <br>
                    <h3>Something Special For Everyone</h3>
                    <br>
                    <p>We understand that not everyone has liquid cash ready to pay for all the needed works to get their books
                    published. This endless special deal is designed for people who cannot afford or who are struggling to afford
                    all the publishing costs.</p>

                    <p>We offer very low monthly premiums - most affordable to contribute to the overall publishing project</p>

                    <p>Premium rates never increase!</p>

                    <p>Cover ALL publishing costs!</p>

                    <div class="clearfix"> </div>
                </div>
                <br>
                <div class="col-md-6 w3ls_about_grid_right">
                    <img src="/public/images/frontend_images/banners/9.png" alt=" " class="img-responsive" />
                </div>
                <div class="clearfix"> </div>
            </div>
        </div>
    </div>
    <!-- //about -->
    <div class="w3l_related_products">
        <div class="container">
            <p style="text-align: center">Thanks to our growing community and the partnerships we nurture,
                we’re able to offer you multiple membership choices so you can choose what works best
                with your lifestyle and budget.</p>
            <p style="text-align: center"> At all levels, you can enjoy access to unique publishing experiences and take advantage
                  of Helpmyworld Publishing exclusive prices.</p>
            <br>
            <br>
            <h3>Membership Levels</h3>
            <div class="col-md-4">
                    <div class="w3l_related_products_grid">
                        <div class="agile_ecommerce_tab_left dresses_grid">
                            <div >
                                <h3>Jadeite</h3>
                                <h5>Editing</h5>
                                <h5>Book Cover and Layout</h5>
                                <h5>ISBN and Barcode</h5>
                                <h5>EBook on amazon</h5>
                                <h5>Sales and advertising on Helpmyworld online store</h5>
                                <h5>Printing 30 Copies </h5>
                            </div>
                            <br>
                            <div class="simpleCart_shelfItem">
                                <br>
                            <h2><span>R320</span></h2>
                            </div>

                            <div class="simpleCart_shelfItem">
                                <p ><a class="item_add" href="{{url('login-register')}}" style="color: #50bfb6">Sign Up</a></p>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="col-md-4">
                    <div class="w3l_related_products_grid">
                        <div class="agile_ecommerce_tab_left dresses_grid">
                            <div >
                                <h3> Musgravite</h3>
                                <h5>Editing</h5>
                                <h5>Book Cover and Layout</h5>
                                <h5>Author’s one page website</h5>
                                <h5>ISBN and Barcode</h5>
                                <h5>EBook on amazon</h5>
                                <h5>Sales and advertising on Helpmyworld online store</h5>
                                <h5>Printing 50 Copies </h5>
                            </div>
                            <div class="simpleCart_shelfItem">
                                <br>
                                <h2><span>R420</span></h2>
                            </div>

                            <div class="simpleCart_shelfItem">
                                <p ><a class="item_add" href="{{url('login-register')}}" style="color: #50bfb6">Sign Up</a></p>
                            </div>
                        </div>
                    </div>
             </div>
            <div class="col-md-4">
                    <div class="w3l_related_products_grid">
                        <div class="agile_ecommerce_tab_left dresses_grid">
                            <div >
                                <h3>Blue Diamond</h3>
                                <h5>Editing</h5>
                                <h5>Book Cover and Layout</h5>
                                <h5>Author’s five pages website</h5>
                                <h5>30 days of free advertising and promotional
                                    ads on affiliates websites and social media</h5>
                                <h5>ISBN and Barcode</h5>
                                <h5>EBook on amazon</h5>
                                <h5>Sales and advertising on Helpmyworld online store</h5>
                                <h5>Printing 60 Copies </h5>
                            </div>
                            <div class="simpleCart_shelfItem">
                                <br>
                                <h2><span>R570</span></h2>
                            </div>

                            <div class="simpleCart_shelfItem">

                               <button> <p ><a class="item_add" href="{{url('login-register')}}" style="color: #50bfb6">Sign Up</a></p></button>
                            </div>
                        </div>
                    </div>
             </div>
        </div>
    </div>
    <div class="team-bottom">
        <div class="container">
            <h3>It gets  <span>Better and Better</span> !</h3>
            {{--<p>Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis--}}
            {{--voluptatibus maiores alias consequatur aut perferendis doloribus asperiores--}}
            {{--repellat.</p>--}}
            {{--<a href="dresses.html">Shop Now</a>--}}

            <p style="text-align: center">Refer 4 people to sign up for any package and pay only R50 per month.

            </p>
            <p style="text-align: center"> Refer 8 people to sign up for any package and pay zero cents “Mahala / nothing”.</p>
        </div>
    </div>
    {{--<div class="container">--}}


        {{--<!-- Services-->--}}


        {{--<div class="services-container">--}}
        {{--<div class="container">--}}

        {{--<div class="row">--}}
        {{--<div class="col-sm-3">--}}
        {{--<div class="service wow fadeInUp">--}}
        {{--<div class="col-sm-12 col-sm-offset-4">--}}
        {{--<div class="service-icon"><i class="fa fa-eye"></i></div>--}}
        {{--</div>--}}
        {{--<h3 style="text-align: center;">Editing</h3>--}}
        {{--<p style="text-align: justify;">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et...</p>--}}

        {{--</div>--}}
        {{--</div>--}}
        {{--<div class="col-sm-3">--}}
        {{--<div class="service wow fadeInDown">--}}
        {{--<div class="col-sm-12 col-sm-offset-4">--}}
        {{--<div class="service-icon "><i  class="fa fa-magic"></i>--}}

        {{--</div>--}}
        {{--</div>--}}

        {{--<h3 style="text-align: center;">Cover Design</h3>--}}
        {{--<p style="text-align: justify;">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et...</p>--}}

        {{--</div>--}}
        {{--</div>--}}
        {{--<div class="col-sm-3">--}}
        {{--<div class="service wow fadeInUp">--}}
        {{--<div class="col-sm-12 col-sm-offset-4">--}}
        {{--<div class="service-icon"><i class="fa fa-table"></i>--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--<h3 style="text-align: center;">Website</h3>--}}
        {{--<p style="text-align: justify;">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et...</p>--}}

        {{--</div>--}}
        {{--</div>--}}
        {{--<div class="col-sm-3">--}}
        {{--<div class="service wow fadeInDown">--}}
        {{--<div class="col-sm-12 col-sm-offset-4">--}}
        {{--<div class="service-icon"><i class="fa fa-print"></i></div>--}}
        {{--</div>--}}
        {{--<h3 style="text-align: center;">Printing</h3>--}}
        {{--<p style="text-align: justify;">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et...</p>--}}

        {{--</div>--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--<br>--}}
        {{--<br>--}}
        {{--<!-- Services Full Width Text -->--}}
        {{--<div class="row">--}}
            {{--<div class="col-md-8">--}}
                {{--<div class="services-full-width-container">--}}
                    {{--<div class="container">--}}
                        {{--<div class="row">--}}
                            {{--<div class="col-sm-6">--}}
                                {{--<div class="service wow fadeInUp">--}}
                                    {{--<div class="col-sm-12 col-sm-offset-6">--}}

                                        {{--<i class="fa fa-edit" style="font-size:55px"></i>--}}

                                        {{--<div class="col-sm-6">--}}
                                        {{--<div class="service-icon"><i class="fa fa-eye"></i></div>--}}
                                        {{--</div>--}}

                                    {{--</div>--}}
                                    {{--<h3 style="text-align: center;">Editing And Proof Reading</h3>--}}
                                    {{--<p style="text-align: center;">Our proof reading and editing does not have a specific turnaround. The turnround around is depended on the work of the project.</p>--}}

                                {{--</div>--}}
                            {{--</div>--}}

                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<br>--}}
                {{--<div class="services-full-width-container">--}}
                    {{--<div class="container">--}}
                        {{--<div class="row">--}}
                            {{--<div class="col-sm-6">--}}
                                {{--<div class="service wow fadeInDown">--}}
                                    {{--<div class="col-sm-12 col-sm-offset-6">--}}
                                        {{--<div class="service-icon "><i  class="fa fa-magic"></i>--}}

                                        {{--</div>--}}
                                    {{--</div>--}}

                                    {{--<h3 style="text-align: center;">Cover & Book Design</h3>--}}
                                    {{--<p style="text-align: center;">We do both cover and book design. You tell us what you need then we see to it that we delever to you--}}
                                        {{--the best work quality designs that meets your theme project and more.</p>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<br>--}}
                {{--<div class="services-full-width-container">--}}
                    {{--<div class="container">--}}
                        {{--<div class="row">--}}
                            {{--<div class="col-sm-6">--}}
                                {{--<div class="service wow fadeInUp">--}}
                                    {{--<div class="col-sm-12 col-sm-offset-6">--}}
                                        {{--<div class="service-icon"><i class="fa fa-table"></i>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                    {{--<h3 style="text-align: center;">Author/Book Website</h3>--}}
                                    {{--<p style="text-align: center;">We design website for books and authors. You tell us what you want, we would advise, then both you and us--}}
                                        {{--would find the best way forward. </p>--}}
                                    {{--<p style="text-align: center;">We do not have a specific turnaround period for design and web development. The turnaround period is--}}
                                        {{--determined by the specific project.</p>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<br>--}}
                {{--<div class="services-full-width-container">--}}
                    {{--<div class="container">--}}
                        {{--<div class="row">--}}
                            {{--<div class="col-sm-6">--}}
                                {{--<div class="service wow fadeInUp">--}}
                                    {{--<div class="col-sm-12 col-sm-offset-6">--}}
                                        {{--<div class="service-icon"><i class="fa fa-print"></i>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                    {{--<h3 style="text-align: center;">Printing And Packaging</h3>--}}
                                    {{--<p style="text-align: center;">Once your complete materials are submitted for printing it take two weeks to prepare everything neatly and read.</p>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<br>--}}
                {{--<div class="services-full-width-container">--}}
                    {{--<div class="container">--}}
                        {{--<div class="row">--}}
                            {{--<div class="col-sm-6">--}}
                                {{--<div class="service wow fadeInUp">--}}
                                    {{--<div class="col-sm-12 col-sm-offset-6">--}}
                                        {{--<div class="service-icon"><i class="fa fa-print"></i>--}}
                                        {{--</div>--}}
                                        {{--<i class="fa fa-barcode" style="font-size:55px"></i>--}}

                                    {{--</div>--}}
                                    {{--<h3 style="text-align: center;">ISBN Registration & Barcodes Image</h3>--}}
                                    {{--<p style="text-align: center;">Getting an ISBN is easy, you may do it with the South African National Library. Once that is--}}
                                        {{--done you may come to us to transform you ISBN to a high quality barcode for you book</p>--}}
                                    {{--<p style="text-align: center;">We offer different formats for barcodes (PNG, JPEG, PDF & EPS</p>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}


            {{--<br>--}}
            {{--<br>--}}
            {{--<div class="col-md-4">--}}
                {{--<div class="well">--}}
                    {{--<ul class="side_nav">--}}
                        {{--<h3>How Much Will IT Cost?</h3>--}}
                        {{--<div class="desc"></div>--}}
                        {{--<p>Because the writer's needs and projects are different, we will charge according to the writer's--}}
                            {{--unique projects.--}}
                        {{--</p>--}}
                        {{--<br>--}}
                        {{--<div class="desc"></div>--}}
                        {{--<p>We do not have specific packaging prices. This makes the process more efficient.--}}
                        {{--</p>--}}
                        {{--<br>--}}
                        {{--<div class="desc"></div>--}}
                        {{--<p>Contact Our Support Team at: helpmyworld@icloud.com for information about project prices and more.--}}
                        {{--</p>--}}
                        {{--<br>--}}
                        {{--<div class="desc"></div>--}}
                        {{--<p>Come work with us to experience the best client service. You are more than a client to us.--}}
                        {{--</p>--}}
                        {{--<br>--}}

                    {{--</ul>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--<br>--}}
        {{--<br>--}}

    {{--</div>--}}




@endsection
