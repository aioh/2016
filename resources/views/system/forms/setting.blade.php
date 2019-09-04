@extends('layout/admin')

@section('content')
	<h2 class="page-title">{{$title}} <small>form</small></h2>
	<div class="row">
		<div class="col-lg-9">
			<section class="widget">                    
				<div class="body">
					{!! Form::open(array('url'=>$url,'method'=>$method,'class'=>'form-horizontal','id'=>'article-form','files'=>true))!!}
					@if($errors->all())
					<div class="alert alert-danger">
						@foreach($errors->all() as $error)
						<p>{{$error}}</p>
						@endforeach
					</div>
					@endif
					<fieldset>
						<legend class="section">Setting information</legend>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="var">Var <span class="required">*</span></label>
							<div class="col-sm-6">
								<input type="text" name="var" required="required" class="form-control"  value="{{$obj->var or old('var') }}">
							</div>
						</div>	
						<div class="form-group">
							<label class="col-sm-2 control-label" for="var">Label <span class="required">*</span></label>
							<div class="col-sm-6">
								<input type="text" name="label" required="required" class="form-control"  value="{{$obj->label or old('label') }}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="var">Type <span class="required">*</span></label>
							<div class="col-sm-6">
								<select name="type" required="required" class="select-block-level chzn-select">
									<option>Choose Type</option>                                                
									<option value="text" @if(isset($obj)&&$obj->type=='text') selected @endif >Text</option>                                                
									<option value="textarea" @if(isset($obj)&&$obj->type=='textarea') selected @endif>Textarea</option>                                                
									<option value="date" @if(isset($obj)&&$obj->type=='date') selected @endif>Date</option>                                                
									<option value="datetime" @if(isset($obj)&&$obj->type=='datetime') selected @endif>DateTime</option>                                                
								</select>	
							</div>
						</div>						
					</fieldset>
					<div class="form-actions">
                        <div class="row">
	                        <div class="col-sm-8 col-sm-offset-4">
	                           	<button type="submit" class="btn btn-primary">Submit</button>
	                            <a href="{{url($link_back)}}" class="btn btn-default">Cancel</a>
	                        </div>
	                    </div>
	                </div>
					{!! Form::close() !!}                    
				</div>
			</section>
		</div>            
	</div>
	<div class="loader-wrap hiding hide">
		<i class="fa fa-circle-o-notch fa-spin"></i>
	</div>
@stop