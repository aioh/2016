@extends('layout.site')

@section('content')
<section>
	<div class="container" id="main-news-inside">
		<div class="row">			
			<div class="col-sm-9">
				<div class="row">
					<div class="col-sm-10 col-sm-offset-1">
						<div class="main-detail">
							<div class="text-center">
								@if(sizeof(json_decode($obj->main_images))>0)
									<div id="owl-demo" class="owl-carousel owl-theme">
										@foreach(json_decode($obj->main_images)->images as $images)
											<div class="item">
												<a href="{{asset($images->path)}}" data-lightbox="main-pic">
													<img src="{{asset($images->path)}}">
												</a>
											</div>
										@endforeach									
									</div>
								@endif
							</div>
							<h1>{{$obj->title}}</h1>							
							<div class="main-date-time">								
								{{ViewHelper::thaiDateFormat($obj->created_at,'Y-m-d')}} <span>|</span> {{date_format($obj->created_at,'H:i:s')}}								
							</div>
							<div class="detail">
								{!!$obj->content!!}
								<hr/>
								<div class="main-social">
									<span>Share this: 
										<a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{Request::url()}}"> 
											<i class="fa fa-facebook circle"></i>
										</a>
										<a target="_blank" class="twitter-share-button" href="https://twitter.com/intent/tweet?text={!!$obj->title!!}">
											<i class="fa fa-twitter circle"></i>
										</a>
									</span>
								</div>
							</div>
						</div>
					</div>
				</div>	
			</div>			
			<div class="col-sm-3" id="sidebar-right">
				<div class="vdo-channel text-center">
					<h2>VDO CHANNEL</h2>
					<img src="{{asset('assets/site/images/vdo.jpg')}}" class="img-responsive full">
					<?php
						$ad_slide = SystemHelper::getSlider('ad-slide');
					?>
					<img class="hidden-xs img-responsive full" src="{{asset($ad_slide[0]->path)}}">		
					@if(isset($ad_slide[1]))
					<img class="visible-xs img-responsive full" src="{{asset($ad_slide[1]->path)}}">		
					@endif
				</div>
			</div>
		</div>
	</div>
</section>
@stop