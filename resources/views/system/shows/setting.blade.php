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
						@foreach($objs as $obj)
						<?php 
							$data['field'] = $obj;
							$data['value'] = '';
							$tmp_val = $obj->translateOrDefault(Session::get('language_local'));
							if($tmp_val!=null)
							{
								$data['value'] = $tmp_val->value;
							}							
							if($obj->type=='textarea')
							{
								$editor[] = $obj->var;							
							}
						?>
							@include('system.render.'.$obj->type,$data)						             
						@endforeach        
					</fieldset>
					<div class="form-actions">
                        <div class="row">
	                        <div class="col-sm-8 col-sm-offset-4">
	                            <button type="submit" class="btn btn-primary">Submit</button>
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