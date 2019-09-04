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
						<legend class="section">{{$title}} Name</legend>
                        <div class="form-group">
                            <div class="col-sm-4"><input type="text" id="name" name="name" required="required" class="form-control" value="{{$obj->name or old('name')}}"></div>
                        </div>
                        <?php
	                        $upload_image[] = ['label'=>'Images','target'=>'main_image','preview'=>'preview-main-image']; // it's col for thumbnail. other use option col.
                        ?>
                        @foreach($upload_image as $image)
								<section id="uploader-{{$image['target']}}" data-target="target">
									<legend class="section">{{$image['label']}}</legend>
									<div class="form-group">
										<div class="col-xs-4" style="padding-right:0px;">
											<input type="file" class="choose form-control" id="{{$image['target']}}" name="{{$image['target']}}[]" style="border-radius:0;">
											<input type="hidden" name="target" value="{{$image['target']}}">
										</div>
										<div class="col-xs-3" style="padding-left:0px;">
											<button class="btn btn-primary upload" style="border-radius:0;" data-preview="{{$image['preview']}}" data-target="{{$image['target']}}">Upload</button>
										</div>																	
									</div>		
									<div class="form-group sortable" id="{{$image['preview']}}">
										@if($image['target']=='thumbnail')
											@if(isset($obj)&&$obj->thumbnail!='')
												<?php							
													$tmp_images = json_decode($obj->thumbnail);								
													$i = 0;
												?>
												@foreach($tmp_images as $item)												
												<div class="preview">
													<div class="col-sm-5">
														<img src="{{url($item->path)}}" class="full-width">
														<input type="hidden" name="images[{{$image['target']}}][path][]" value="{{$item->path}}">
														<input type="hidden" name="images[{{$image['target']}}][target][]" value="{{$image['target']}}">
														<div class="text-center martop delete"><span class="badge">DELETE</span></div>
													</div>
													<div class="col-sm-7">
														<div class="martop"><input type="text" name="images[{{$image['target']}}][alt][]" value="{{$item->alt}}" placeholder="ALT" class="form-control"></div>
														<div class="martop"><input type="text" name="images[{{$image['target']}}][link][]" value="{{$item->link}}" placeholder="Link" class="form-control"></div>
														<div class="martop">
															<textarea name="images[{{$image['target']}}][caption][]" placeholder="Caption"  class="form-control" rows="2">{{$item->caption}}</textarea>
														</div>																		
													</div>
												</div>
												@endforeach																							
											@endif
										@else
											@if(isset($obj)&&$obj->option!='')
											<?php							
												$tmp_images = json_decode($obj->option);																																																						
											?>												
												@if(isset($tmp_images->$image['target']))
													@foreach($tmp_images->$image['target'] as $item)	
														<?php 
															$image_extension = ['png','jpg','gif']; 
															$tmp             = explode('.', $item->path);
														?>											
														@if(in_array(end($tmp),$image_extension))
															@include('system.forms.preview')
														@else
															@include('system.forms.preview-file')
														@endif													
													@endforeach												
												@endif
											@endif
										@endif
									</div>		
								</section>					
							@endforeach
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
		$(".sortable").sortable({
            placeholder: 'preview',
            forcePlaceholderSize: true
        });	
		function saveFile(file,target,preview){
            data = new FormData();
            data.append("file", file[0]);//You can append as many data as you want. Check mozilla docs for this
            @if(isset($obj))
	            data.append("obj_id", {{$obj->id}});//You can append as many data as you want. Check mozilla docs for this
            @endif
            data.append("type", 'slide');
            $_token = "{{ csrf_token() }}";
            data.append('_token',$_token);
            $.ajax({
                data: data,
                type: "POST",
                url: '{{url('system/upload/file')}}',
                cache: false,
                contentType: false,
                processData: false,
                success: function(data){
                	console.log(data);
                	$.post( "{{url('system/load/preview')}}", { data: data,_token:$_token,target:target })
					  	.done(function( data_preview ) {					  		
					  		// console.log(data_preview);
					  		$('#'+preview).append(data_preview);
					});                	              
                }
            });
        }
        $('body').delegate('.delete','click',function(){
		    checked = confirm('Are you sure?');
			if(checked)
			{
				var target  = $(this).data('target');
				var list    = $(this).data('list');
				var obj = $(this);
				$.post( "{{url('system/delete/file')}}", { target: target, list: list,_token:$_token })
				  	.done(function( data ) {
					    $(obj).parents('.preview').remove();
					    Messenger({
                        type: "error",
	                        extraClasses:'messenger-fixed messenger-on-right messenger-on-top'
	                    }).post('Delete');
				 });
			}	
		});  		
	</script>
@stop