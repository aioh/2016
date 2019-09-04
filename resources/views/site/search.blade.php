@extends('layout.site')

@section('content')
	<section id="main-content">
		<div class="container">
			<div class="row">
				<div id="top-post" class="section">
					<div class="col-sm-12 section-topic">
						<h3>ค้นหา</h3>
					</div>
					<div class="articles">
						@foreach($posts as $item)
							<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
								<div class="article">
									<div class="text-center">									
										@if(isset(json_decode($item->thumbnail)[0]->path))
											<div class="thumbnail" style="background-image:url({{asset(json_decode($item->thumbnail)[0]->path)}})">
											
											</div>
										@else
											<div class="thumbnail" style="background-image:url({{asset('assets/site/images/article.jpg')}})">
											
											</div>
										@endif
									</div>
									<div class="date-time">
										<h4>
											<span class="date pull-left">
												{{ViewHelper::thaiDateFormat($item->created_at,'Y-m-d')}}
											</span>
											<span class="time pull-right">
												{{date_format($item->created_at,'H:i:s')}}
											</span>
										</h4>
									</div>
									<div>
										<h4 class="topic">
											@if(mb_strlen($item->title)>100)
												{{mb_substr($item->title, 0,90)}}...
											@else
												{{mb_substr($item->title, 0,100)}}
											@endif
										</h4>
										<p class="detail">
											@if(isset($tmp_option->short))
												{{$tmp_option->short}}		
											@endif								
										</p>
										<div class="text-center">
										<a href="{{url($item->slug)}}"><button class="btn my-btn">อ่านต่อ</button></a>
										</div>
									</div>
								</div>
							</div>
						@endforeach	
						<div class="col-xs-12">
							<div class="pull-right">
								{!! $posts->appends(['search'=>$search])->render() !!}		
							</div>
						</div>						
					</div>
				</div>
			</div>
		</div>
	</section>
@stop