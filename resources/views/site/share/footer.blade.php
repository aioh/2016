<footer>
		<div class="container">
			<div class="row">
				<div class="col-sm-9">
					<?php
						$ad_bottom = SystemHelper::getSlider('ad-bottom');
					?>
					<img class="img-responsive" src="{{asset($ad_bottom[0]->path)}}">
				</div>
				<div class="col-sm-3">
					<div class="contact-footer">	
						<div class="contact-footer-text">
							<i class="glyphicon glyphicon-gift"></i> {{$setting['contact_email']}}<br/>
							<i class="glyphicon glyphicon-flash"></i> {{ViewHelper::getCountPosts()}} {{$setting['news']}}<br/>
							<i class="glyphicon glyphicon-user"></i> {{$counter+68000}}
                            {{$setting['visitors']}}<br/>
                            @if($setting['facebook_link']!='')
                            <i class="glyphicon" style="
							    background: url('{{asset('assets/site/images/facebook.png')}}');
							    width: 17px;
							    background-size: 17px 17px;
							    height: 17px;
							    background-repeat: no-repeat;
							    background-position: 2 2;
							"></i> <a style="color:white;" href="{{$setting['facebook_link']}}" target="_blank">Facebook</a><br/>
                            @endif
                            @if($setting['twitter_link']!='')
                            <i class="glyphicon" style="
							    background: url('{{asset('assets/site/images/twitter.png')}}');
							    width: 17px;
							    background-size: 17px 17px;
							    height: 17px;
							    background-repeat: no-repeat;
							    background-position: 2 2;
							"></i> <a style="color:white;" href="{{$setting['twitter_link']}}" target="_blank">Twitter</a><br/>
                            @endif
						</div>						
					</div>
				</div>
			</div>
		</div>
	</footer>
	<div id="copyright">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					&copy; <span class="main-color">FM91BKK</span> website -All Rights Reserve 2017
					<!--<div class="visible-xs" style="margin-top:10px;">
						@if($setting['facebook_link']!='')
							<a href="{{$setting['facebook_link']}}" target="_blank">
								<img src="{{asset('assets/site/images/facebook.png')}}" width="25">
							</a>
						@endif
						@if($setting['twitter_link']!='')
							<a href="{{$setting['twitter_link']}}" target="_blank" style="margin-left:5px;">
								<img src="{{asset('assets/site/images/twitter.png')}}" width="25">
							</a>
						@endif
					</div>
					<div class="pull-right hidden-xs">
						<div class="contact-footer-social">
							@if($setting['facebook_link']!='')
								<a href="{{$setting['facebook_link']}}" target="_blank" style="position: absolute;right: 5px;">
									<img src="{{asset('assets/site/images/facebook.png')}}" width="25">
								</a>
							@endif
							@if($setting['twitter_link']!='')
								<a href="{{$setting['twitter_link']}}" target="_blank" style="position: absolute;">
									<img src="{{asset('assets/site/images/twitter.png')}}" width="25">
								</a>
							@endif
						</div>
					</div>-->
				</div>
			</div>
		</div>
	</div>
	@include('site.share.js')
