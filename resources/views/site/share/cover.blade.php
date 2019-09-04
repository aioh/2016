<?php
$cover = SystemHelper::getSlider('cover');
?>
<section id="cover" style="background:url('{{$cover[0]->path}}') 50% 50%">
	<div class="container">
		<div class="row">
			<div class="col-sm-8 col-sm-offset-2 text-center">
				{!!Form::open(array('url' => url('search'), 'method' => 'get','id'=>'search-box')) !!}
				<div class="row">
					<div class="col-sm-9">
						<input type="text" required name="search" class="form-control" id="search" >
					</div>
					<div class="col-sm-3">
						<button class="btn my-btn">{{$setting['search_now']}}</button>
					</div>
				</div>					
				{!!Form::close()!!}					
			</div>
		</div>			
	</div>
</section>
<section id="audio">
	<div class="text-center">
		<audio controls="true"><source src="http://122.155.16.48:8955/;stream.mp3" type="audio/mp3">Your browser does not support the audio element.</audio>
	</div>
</section>