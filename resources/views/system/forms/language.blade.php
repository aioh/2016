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
						<legend class="section">Languages information</legend>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="var">Name <span class="required">*</span></label>
							<div class="col-sm-6">
								<input type="text" name="name" required="required" class="form-control"  value="{{$obj->name or old('name') }}">
							</div>
						</div>	
						<div class="form-group">
							<label class="col-sm-2 control-label" for="var">Key <span class="required">*</span></label>
							<div class="col-sm-6">
								<input type="text" name="key" required="required" class="form-control"  value="{{$obj->key or old('key') }}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="var">Default <span class="required">*</span></label>
							<div class="col-sm-6">
								<select name="default" required="required" class="select-block-level chzn-select">									
									<option value="0" @if(isset($obj)&&$obj->default==0) selected @endif >No</option>                                                									
									<option value="1" @if(isset($obj)&&$obj->default==1) selected @endif >Yes</option>                                                									
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