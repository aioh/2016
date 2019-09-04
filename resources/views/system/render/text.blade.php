<div class="form-group">
	<label class="col-sm-2 control-label" for="title">{{$field->label}}</label>
	<div class="col-sm-6">
		<input type="text" name="{{$field->var}}" class="form-control"  value="{{ $value or old($field->var) }}">
	</div>
</div>