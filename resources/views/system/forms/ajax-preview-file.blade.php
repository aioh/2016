<div class="preview">
	<div class="col-sm-5 text-center">
		<i style="font-size:50px;" class="glyphicon glyphicon-file"></i>
		<input type="hidden" name="images[{{$target}}][path][]" value="{{$path}}">
		<input type="hidden" name="images[{{$target}}][target][]" value="{{$target}}">
		<div class="text-center martop delete"><span class="badge badge-danger">DELETE</span></div>
	</div>
	<div class="col-sm-7">
		<strong>filename:</strong> {{$path}}
		<div class="martop"><input type="hidden" name="images[{{$target}}][alt][]" value="" placeholder="ALT" class="form-control"></div>
		<div class="martop"><input type="hidden" name="images[{{$target}}][link][]" value="" placeholder="Link" class="form-control"></div>
		<div class="martop">
			<textarea name="images[{{$target}}][caption][]" placeholder="Caption"  class="form-control hidden" rows="2"></textarea>
		</div>																		
	</div>
</div>