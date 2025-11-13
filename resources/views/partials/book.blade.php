


                    <div class="w3ls_dresses_grid_right_grid3">

                            <div class="col-md-4 agileinfo_new_products_grid agileinfo_new_products_grid_dresses">
                                <div class="agile_ecommerce_tab_left dresses_grid">
                                    <div class="hs-wrapper hs-wrapper2">
                                        <a href="{{route('books.single', $book->slug)}}"><h3 text align="center">{{$book->name}}</h3></a>

                                        <a href="{{route('books.single', $book->slug)}}"><img src="{{url('images',$book->image)}}" alt=" " class="img-responsive"/></a>

                                    </div>
                                    <a href="{{route('books.single', $book->slug)}}"><h3 text align="center">{{$book->name}}</h3></a>
                                    <div class="simpleCart_shelfItem">

                                        <p><span></span><i class="item_price"> R{{$book->price}}</i></p>

                                        <p><a class="item_add" style="background-color: #50bfb6" href="{{route('cart.addItem',$book->id)}}">Add to cart</a></p>

                                        <p> <a class="item_add" style="background-color: #50bfb6" href="{{route('books.single', $book->slug)}}">Read More</a></p>
                                    </div>
                                    <div class="dresses_grid_pos">
                                        <h6>New</h6>
                                    </div>
                                </div>
                            </div>

                    </div>



