<div class="left-sidebar">
					<h2>Category</h2>
						<div class="panel-group category-products" id="accordian">
							<!--category-products-->
							@foreach($categories as $cat)
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title">
										<a data-toggle="collapse" data-parent="#accordian" href="#{{$cat->id}}">
											<span class="badge pull-right"><i class="fa fa-plus"></i></span>
											{{$cat->name}}
										</a>
									</h4>
								</div>
								<div id="{{$cat->id}}" class="panel-collapse collapse">
									<div class="panel-body">
										<ul>
											@foreach($cat->categories as $subcat)
												@if($subcat->status==1)
												<li><a href="{{ asset('products/'.$subcat->url) }}">{{$subcat->name}} </a></li>
												@endif
											@endforeach
										</ul>
									</div>
								</div>
							</div>
							@endforeach

						</div><!--/category-products-->
                                                                        
                                                                        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- Ad -->
<ins class="adsbygoogle"
     style="display:inline-block;width:160px;height:600px"
     data-ad-client="ca-pub-1026112827105560"
     data-ad-slot="6196006486"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
					</div>