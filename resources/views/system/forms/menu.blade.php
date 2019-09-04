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
						<legend class="section">{{$title}} Info</legend>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="name">Name <span class="required">*</span></label>
                            <div class="col-sm-6"><input type="text" name="name" required="required" class="form-control" value="{{$obj->name or old('name')}}"></div>
                        </div> 
						<legend class="section">Order {{$title}}</legend>
                        @if(isset($obj))
							<ol id="order" class="list-group list-group-outer sortable list-group-sortable">
							@foreach($data as $post)
								<?php $post = $post->translateOrDefault(Session::get('language_local'));?>
			                    <li class="list-group-item">
			                        <i class="fa fa-sort"></i>
			                        <input type="hidden" name="order[]" value="{{$post->id}}">
			                         &nbsp; &nbsp;<strong>ID: {{$post->id}}</strong><br/>
			                         &nbsp; &nbsp;&nbsp; &nbsp;TITLE: {{$post->menu_title}}
			                    </li>								
							@endforeach
							</ol>
						@endif                                             
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

@section('script')
	<script type="text/javascript">	
		$("#order").sortable({
            placeholder: 'preview',
            forcePlaceholderSize: true
        });
    </script>
@stop