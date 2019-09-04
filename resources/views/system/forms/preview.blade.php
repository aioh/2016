<div class="preview">
	<div class="col-sm-5 text-center">
		<img src="{{url($item->path)}}" class="full-width">
		<input type="hidden" name="images[{{$image['target']}}][path][]" value="{{$item->path}}">
		<input type="hidden" name="images[{{$image['target']}}][target][]" value="{{$image['target']}}">
		<div class="text-center martop delete"><span class="badge badge-danger">DELETE</span></div>
	</div>
	<div class="col-sm-7">
		<div class="martop"><input type="text" name="images[{{$image['target']}}][alt][]" value="{{$item->alt}}" placeholder="ALT" class="form-control"></div>
		<div class="martop"><input type="text" name="images[{{$image['target']}}][link][]" value="{{$item->link}}" placeholder="Link" class="form-control"></div>
		<div class="martop">
			<textarea name="images[{{$image['target']}}][caption][]" placeholder="Caption"  class="form-control" rows="2">{{$item->caption}}</textarea>
		</div>																		
	</div>
</div>