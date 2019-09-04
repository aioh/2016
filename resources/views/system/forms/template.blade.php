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
						<legend class="section">Template Info</legend>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="template">Template <span class="required">*</span></label>
                            <div class="col-sm-6"><input type="text" name="template" required="required" class="form-control" value="{{$obj->template or old('template')}}"></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="is_create">Create <span class="required">*</span></label>
                            <div class="col-sm-6">
                            	<label><input name="is_create" value="1" @if(!isset($obj)||(isset($obj)&&$obj->is_create==1)) checked @endif type="radio"> Yes</label>
                            	<label><input name="is_create" value="0" @if(isset($obj)&&$obj->is_create==0) checked @endif type="radio"> No</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="is_delete">Delete <span class="required">*</span></label>
                            <div class="col-sm-6">
                            	<label><input name="is_delete" value="1"  @if(!isset($obj)||(isset($obj)&&$obj->is_delete==1)) checked @endif type="radio"> Yes</label>
                            	<label><input name="is_delete" value="0" @if(isset($obj)&&$obj->is_delete==0) checked @endif type="radio"> No</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="is_show">Show <span class="required">*</span></label>
                            <div class="col-sm-6">
                            	<label><input name="is_show" value="1"  @if(!isset($obj)||(isset($obj)&&$obj->is_show==1)) checked @endif type="radio"> Yes</label>
                            	<label><input name="is_show" value="0" @if(isset($obj)&&$obj->is_show==0) checked @endif type="radio"> No</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="type">Parent <span class="required">*</span></label>
                            <div class="col-sm-6">
                            	<label><input name="is_parent" value="0" @if(isset($obj)&&$obj->is_parent==0) checked @endif type="radio"> No</label>
                            	<label><input name="is_parent" value="1"  @if(!isset($obj)||(isset($obj)&&$obj->is_parent==1)) checked @endif type="radio"> Yes</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="type">Type <span class="required">*</span></label>
                            <div class="col-sm-6">
                            	<label><input name="type" value="0" @if(isset($obj)&&$obj->type==0) checked @endif type="radio"> Post</label>
                            	<label><input name="type" value="1"  @if(!isset($obj)||(isset($obj)&&$obj->type==1)) checked @endif type="radio"> Page</label>
                            </div>
                        </div>
                         <div class="form-group">
                            <label class="control-label col-sm-2" for="pagination">Pagination <span class="required">*</span></label>
                            <div class="col-sm-6"><input type="text" name="pagination" required="required" class="form-control" value="{{$obj->pagination or old('pagination')}}"></div>
                        </div>
                        <legend class="section">Extra Field Content <i id="add-field" class="glyphicon glyphicon-plus"></i></legend>
                        <div id="extra-field">
	                        @if(isset($obj))
		                        @foreach($obj->fieldSettings()->where('tab','=','content')->get() as $field)
		                        <div class="setting-field">
			                        <div class="form-group">
			                            <label class="control-label col-sm-2">Label<span class="required">*</span></label>
			                            <div class="col-sm-6">
			                            	<input type="text" name="extra_label[]" required="required" class="form-control" value="{{$field->label}}">
			                            </div>                            
			                        </div>
			                        <div class="form-group">
			                            <label class="control-label col-sm-2">Var<span class="required">*</span></label>
			                            <div class="col-sm-6">
			                            	<input type="text" name="extra_var[]" required="required" class="form-control" value="{{$field->var}}">
			                            </div>                            
			                        </div> 
			                        <div class="form-group">
			                            <label class="control-label col-sm-2">Type<span class="required">*</span></label>
			                            <div class="col-sm-6">
			                            	<select name="extra_type[]" class="form-control">
									    		<option value="text" @if($field->type=='text') selected @endif>Text</option>
									    		<option value="textarea" @if($field->type=='textarea') selected @endif>TextArea</option>
									    		<option value="date" @if($field->type=='date') selected @endif>Date</option>
									    		<option value="datetime" @if($field->type=='datetime') selected @endif>Datetime</option>
									    	</select>
			                            </div>                            
			                        </div>              
									<div class="form-group">
			                            <label class="control-label col-sm-2"></label>
			                            <div class="col-sm-6">
			                            <button class="delete btn btn-danger">Delete</button>
			                            </div>                            
			                        </div>              
			                        
			                        <legend class="section"></legend>
			                    </div>
		                        @endforeach
		                    @endif
	                    </div>
                        <legend class="section">Extra Field Image <i id="add-image" class="glyphicon glyphicon-plus"></i></legend>
                        <div id="extra-image">
	                        @if(isset($obj))
		                        @foreach($obj->fieldSettings()->where('tab','=','image')->get() as $field)
		                        <div class="setting-field">
			                        <div class="form-group">
			                            <label class="control-label col-sm-2">Label<span class="required">*</span></label>
			                            <div class="col-sm-6">
			                            	<input type="text" name="extra_image_label[]" required="required" class="form-control" value="{{$field->label}}">
			                            </div>                            
			                        </div>
			                        <div class="form-group">
			                            <label class="control-label col-sm-2">Var<span class="required">*</span></label>
			                            <div class="col-sm-6">
			                            	<input type="text" name="extra_image_var[]" required="required" class="form-control" value="{{$field->var}}">
			                            </div>                            
			                        </div> 
			                        <div class="form-group">
			                            <label class="control-label col-sm-2"></label>
			                            <div class="col-sm-6">
			                            	<button class="delete btn btn-danger">Delete</button>
			                            </div>                            
			                        </div>                        
			                        <legend class="section"></legend>
		                        </div>
		                        @endforeach
		                    @endif
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

@section('script')
	<script type="text/javascript">	
		$('.upload').click(function(){			
			var target  = $(this).data('target');
			var preview = $(this).data('preview');			
			saveFile(document.getElementById(target).files,target,preview);
			$("#"+target).val('');
			return false;
		});
		$("#extra-field").sortable({
            placeholder: 'preview',
            forcePlaceholderSize: true
        });
        $("#extra-image").sortable({
            placeholder: 'preview',
            forcePlaceholderSize: true
        });		
        $("#add-field").click(function(){        	
        	$.get( "{{url('system/templates/add/field')}}", function( data ) {
			 	$( "#extra-field" ).append( data );
			});
        });
        $("#add-image").click(function(){        	
        	$.get( "{{url('system/templates/add/image')}}", function( data ) {
			 	$( "#extra-image" ).append( data );
			});
        });
        $('body').delegate('.delete','click',function(){
		    checked = confirm('Are you sure?');
			if(checked)
			{
				$(this).parents('.setting-field').remove();
				Messenger({
                type: "error",
                    extraClasses:'messenger-fixed messenger-on-right messenger-on-top'
                }).post('Delete');
			}	
			return false;
		});  		
	</script>
@stop