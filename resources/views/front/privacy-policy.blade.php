@extends('layouts.frontLayout.front_design')

@section('content')
    <div id="contact-page" class="container">
        <div class="bg">
            <div class="row">
                <div class="col-sm-12">
                    <h2 class="title text-center">Privacy-Policy</h2>

                </div>
            </div>
            <div class="w3ls_about_grids">
                <div class="col-md-7 w3ls_about_grid_left">


                    {{--<div class="col-xs-2 w3ls_about_grid_left1">--}}
                    {{--<span class="glyphicon glyphicon-new-window" aria-hidden="true"></span>--}}
                    {{--</div>--}}
                    <div class="col-xs-10 w3ls_about_grid_left2">

                        <h3>The following policy applies to subscribers who want to get latest updates</h3>

                        <p>If you register as a subscriber, we do not make your personally identifiable information available to anyone unless required by law to do so.</p>


                        <h3>Information Collected from E-mail:</h3>
                        <p>When you purchase something from our store, as part of the buying and selling process, we collect the personal information you give us such as your name,
                            address and email address.When you browse our store, we also automatically receive your computer’s internet protocol (IP) address in order to provide us with
                            information that helps us learn about your browser and operating system.
                            Email marketing (if applicable): With your permission, we may send you emails about our store, new products and other updates.</p>

                       

                        <h3>Privacy Policy for All Visitors</h3>
                        <h4>This is information Collected and Stored Automatically:</h4>

                       
                            <p>The Internet protocol (IP) address from which you access our web site. An IP address is a
                                unique number that is automatically assigned to the computer you are using whenever you are surfing the web.</p>
                            <p> The type of browser, such as Internet Explorer or Mozilla, and operating system, such as Windows Vista or MacOs, used to access our site.</p>
                            <p>   The date and time our site is accessed, for the purpose of traffic and statistical monitoring.</p>
                            <p>  The pages visited, for the purpose of improving the usefulness of
                                our web site by providing helpful links and removing pages that are not read.</p>
                            <p>This information does not identify you personally.</p>
                            <p> We use this information to make our site more useful to visitors by learning the number of visitors to our site,
                                the number of pages served, and the level of demand for specific pages. We do not track or record information about
                                identifiable individuals and their visits.</p>

                        <h3>Consent</h3>

                        <p>When you provide us with personal information to complete a transaction, verify your credit card, place an order, arrange for a delivery or return a purchase,
                            we imply that you consent to our collecting it and using it for that specific reason only.
                            If we ask for your personal information for a secondary reason, like marketing, we will either ask you directly for your expressed consent,
                            or provide you with an opportunity to say no.</p>
                        <p>You may send an email to helpmyworld@icloud.com to stop any receiving emails from us or for us to stop using your information </p>

                        <h3>Disclosure</h3>

                        <p>We may disclose your personal information if we are required by law to do so or if you violate our Terms of Service.</p>

                    </div>
                    <div class="clearfix"> </div>
                    {{--<div class="col-xs-2 w3ls_about_grid_left1">--}}
                    {{--<span class="glyphicon glyphicon-flash" aria-hidden="true"></span>--}}
                    {{--</div>--}}
                    <div class="col-xs-10 w3ls_about_grid_left2">

                        <h3>Third Party Services</h3>

                        <p>In general, the third-party providers used by us will only collect, use and disclose your information to the extent necessary to allow them to perform the services they provide to us.
                            However, certain third-party service providers, such as payment gateways and other payment transaction processors, have their own privacy policies in respect to the information we are required to provide to them for your purchase-related transactions.
                            For these providers, we recommend that you read their privacy policies so you can understand the manner in which your personal information will be handled by these providers.
                            In particular, remember that certain providers may be located in or have facilities that are located a different jurisdiction than either you or us. So if you elect to proceed with a transaction that involves the services of a third-party service provider, then your information may become subject to the laws of the jurisdiction(s) in which that service provider or its facilities are located.
                            As an example, if you are located in South Africa and your transaction is processed by a payment gateway located in the United States, then your personal information used in completing that transaction may be subject to disclosure under United States legislation, including the Patriot Act.
                            Once you leave our store’s website or are redirected to a third-party website or application, you are no longer governed by this Privacy Policy or our website’s Terms of Service.</p>

                        <h3>Security</h3>

                        <p>To protect your personal information, we take reasonable precautions and follow industry best practices to make sure it is not inappropriately lost,
                            misused, accessed, disclosed, altered or destroyed.
                            If you provide us with your credit card information, the information is encrypted using secure socket layer technology (SSL) and stored with
                            a AES-256 encryption. Although no method of transmission over the Internet or electronic storage is 100% secure, we follow all PCI-DSS
                            requirements and implement additional generally accepted industry standards.
                        </p>

                        <h3>Changes to the privacy policy</h3>

                        <p> We reserve the right to modify this privacy policy at any time, so please review it frequently. Changes and clarifications will take effect immediately upon their posting on the website. If we make material changes to this policy, we will notify you here that it has been updated, so that you are aware of what information we collect, how we use it, and under what circumstances, if any, we use and/or disclose it.
                            If our store is acquired or merged with another company, your information may be transferred to the new owners so that we may continue to sell products to you.
                        </p>

                        <h3>Questions and contact information</h3>

                        <p>If you would like to: access, correct, amend or delete any personal information we have about you, register a complaint, or simply want more
                            information contact our Privacy Compliance Officer at <storng>helpmyworld@icloud.com or by mail at
                                Helpmyworld
                                [Re: Privacy Compliance Officer]
                                416 Seder, 380 Sisulu street, Pretoria, South Africa, 0001</storng>

                        </p>

                    </div>

                </div>
                <div class="col-md-5 w3ls_about_grid_right">
                    {{--<div class="col-xs-2 w3ls_about_grid_left1">--}}
                    {{--<span class="glyphicon glyphicon-new-window" aria-hidden="true"></span>--}}
                    {{--</div>--}}
                    <div class="col-xs-10 w3ls_about_grid_left2">

                        <a href="{{url('terms-and-conditions')}}"><h3>Terms and Conditions</h3></a>
                        {{--<a href="{{url('privacy-policy')}}"><h4>Privacy Policy</h4></a>--}}
                        <a href="{{url('shipping-policy')}}"><h3>Delivery Policy</h3></a>
                        <a href="{{url('cancellation-refund')}}"><h3>Cancellation and Refund</h3></a>

                    </div>
                    <div class="clearfix"> </div>
                    {{--<div class="col-xs-2 w3ls_about_grid_left1">--}}
                    {{--<span class="glyphicon glyphicon-flash" aria-hidden="true"></span>--}}
                    {{--</div>--}}
                    {{--<div class="col-xs-10 w3ls_about_grid_left2">--}}

                    {{--<div class="desc"></div>--}}
                    {{--<a href="{{url('terms-and-conditions')}}"><h4>Terms and Conditions</h4></a>--}}
                    {{--<a href="{{url('privacy-policy')}}"><h4>Privacy Policy</h4></a>--}}
                    {{--<a href="{{url('shipping-policy')}}"><h4>Delivery Policy</h4></a>--}}
                    {{--<a href="{{url('cancellation-refund')}}"><h4>Cancellation and Refund</h4></a>--}}
                    {{--</div>--}}
                </div>
                <div class="clearfix"> </div>
            </div>
        </div>
    </div>

@endsection
