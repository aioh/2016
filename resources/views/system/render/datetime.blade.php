<div class="form-group">
	<label class="col-sm-2 control-label" for="title">{{$field->label}}</label>
	<div class="col-sm-6">
		<input type="text" name="{{$field->var}}" class="date-time-picker form-control"  value="{{ $obj->pivot->title or old('release_date_time') }}">
	</div>
</div>