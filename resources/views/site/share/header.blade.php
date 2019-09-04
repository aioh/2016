<!DOCTYPE html>
<html>
<head>
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
  (adsbygoogle = window.adsbygoogle || []).push({
    google_ad_client: "ca-pub-5385901678058706",
    enable_page_level_ads: true
  });
</script>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>
	สวพ. FM 91 สถานีวิทยุเพื่อความปลอดภัยและการจราจร	
	</title>
	<meta property="og:url" content="{{ URL::full() }}">
	@include('site/share/css')
	@if(isset($obj))
		<meta property="og:title" content="{{$obj->title}}">
	  	@if(isset(json_decode($obj->main_images)->target_facebook)>0)  	
	  		<meta property="og:image" content="{{url(json_decode($obj->main_images)->target_facebook[0]->path)}}" />
	  		<meta property="og:title" content="{{$obj->title}}">
	  	@else
			<meta property="og:image" content="" />
	  	@endif
	@else		
		<meta property="og:title" content="สวพ. FM 91 สถานีวิทยุเพื่อความปลอดภัยและการจราจร">
	  	<meta property="og:description" content="ร่วมดำเนินงานโดย กองตำรวจสื่อสาร สำนักงานตำรวจแห่งชาติและบริษัท วิไลเซ็นเตอร์แอนส์ซันส์ จำกัด
FM 91 TRAFFIC REPORT RADIO STATION COMMUNICATION COMMAND ROYAL THAI POLICE">	 
	 	<meta property="og:image" content="" />
    @endif
    <script>
	function setHeight()
	{
		$('.article .topic').matchHeight();
	}
	</script>
</head>
<body onload="setHeight()">
	<header>	
	<div class="container">
		<div class="pull-right hidden-xs" id="tel-top">
			<h2> 
				<i class="fa fa-phone"></i> {{$setting['tel']}} 
				<span class="call">{{$setting['text_tel']}} </span>
			</h2>
		</div>
	</div>
		<a href="{{url()}}">
		<div id="logo" class="text-center hidden-xs">
			<img src="{{asset('assets/site/images/logo.jpg')}}" class="img-responsive margin-center">
		</div>
		</a>
		@include('site/share/menu')
	</header>
