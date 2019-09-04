<div class="form-group">
	<label class="col-sm-2 control-label" for="title">{{$field->label}} </label>
	<div class="col-sm-10">
		<textarea rows="10" class="form-control" id="{{$field->var}}" name="{{$field->var}}">{{ $value or old($field->var) }}</textarea>
	</div>
</div>