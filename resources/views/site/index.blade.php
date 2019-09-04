@extends('layout.site')

@section('content')
<section id="main-content">
	<div class="container">
		<?php
			$array = [
						array('menu'=>'top post','text'=>'TOP POST','adsname'=>'top post'),
						array('menu'=>'ข่าวการจราจรล่าสุด','text'=>'ข่าวการจราจรล่าสุด','adsname'=>'latest traffic'),
						array('menu'=>'ข่าว 91','text'=>'ข่าว 91','adsname'=>'news 91'),
						array('menu'=>'lost&found','text'=>'ของหายได้คืน','adsname'=>'lost&found'),
						array('menu'=>'บอกเล่า 91','text'=>'บอกเล่า 91','adsname'=>'ad-tell-91'),
					]
		?>
		@foreach($array as $item)
			<?php
			$i = 0;
			$get_posts_menu = SystemHelper::getMenus($item['menu']);
			$adsname = $item['adsname'];
			?>
			@if($get_posts_menu->posts->count())
			<div class="row">				
				<div class="section">
					<div class="col-sm-12 section-topic">
						<h3 class="sp-hidden-xs"><span class="topic">{{$item['text']}}</span>
							@if($get_posts_menu)
							<i>
								<img src="{{asset('assets/site/images/calendar159.png')}}">
								{{ViewHelper::thaiDateFormat($get_posts_menu->posts()->orderBy('id','desc')->first()->created_at)}}
							</i>
							<i>
								<img src="{{asset('assets/site/images/clock104.png')}}">
								อัพเดทล่าสุด {{date_format($get_posts_menu->posts()->orderBy('id','desc')->first()->created_at,'H:i:s')}}
							</i>														
							@endif
						</h3>
						<div class="sp-visible-xs">
							<h3 class="topic">
								<span class="topic">{{$item['text']}}</span>
							</h3>
							<h3>
								<i>
									<img src="{{asset('assets/site/images/calendar159.png')}}">
									{{ViewHelper::thaiDateFormat($get_posts_menu->posts()->orderBy('id','desc')->first()->created_at)}}
								</i>
							</h3>
							<h3>
								<i>
								<img src="{{asset('assets/site/images/clock104.png')}}">
									อัพเดทล่าสุด {{date_format($get_posts_menu->posts()->orderBy('id','desc')->first()->created_at,'H:i:s')}}
								</i>
							</h3>
						</div>
					</div>
					<div class="articles">
						@foreach($get_posts_menu->posts()->orderBy('id','desc')->take(12)->get() as $item)
						<?php
							$tmp = $item->translateOrDefault('th');
							$tmp_option = json_decode($tmp->option);
						?>
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
										<a href="{{url($item->slug)}}">
										<button class="btn my-btn">อ่านต่อ</button></a>
									</div>
								</div>
							</div>
						</div>
						@endforeach	
					</div>
				</div>

				<?php
					$ads_banner = SystemHelper::getSlider($adsname);
				?>
				@if(isset($ads_banner) && isset($ads_banner[0]->path))
				<?php
					if($ads_banner[0]->link != ""){
						$adsLink = "http://".$ads_banner[0]->link;
					}
					else{
						$adsLink = "javascript:void(0)";
					}
				?>
				<div class="adsBanner">
					<a href="{{$adsLink}}" target="_blank">
						<img class="imgBanner" src="{{asset($ads_banner[0]->path)}}">
					</a>
				</div>
				@endif	
			</div>
			@endif
		@endforeach		
	</div>
</section>
@stop