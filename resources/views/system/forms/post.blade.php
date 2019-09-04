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
							<ul id="myTab" class="nav nav-tabs">
								<li class="active"><a href="#content" data-toggle="tab">CONTENT</a></li>
								<li><a href="#attr" data-toggle="tab">ATTRIBUTE</a></li>
								{{-- <li><a href="#seo" data-toggle="tab">SEO</a></li> --}}
								<li><a href="#tab-images" data-toggle="tab">IMAGE</a></li>
								<li><a href="#menu" data-toggle="tab">MENU</a></li>
							</ul>
							<div id="myTabContent" class="tab-content">
								<div class="tab-pane active" id="content">	                            	
									<legend class="section">Content information</legend>
									<div class="form-group">
										<label class="col-sm-2 control-label" for="title">Title</label>
										<div class="col-sm-6">
											<input type="text" id="title" name="title" class="form-control"  value="{{ $language_obj->title or old('release_date_time') }}">
										</div>
									</div>
									<?php
									$editor = ['ck_content'];
									?>
									<div class="form-group">
										<label class="col-sm-2 control-label" for="title">Content <span class="required">*</span></label>
										<div class="col-sm-10">
											<textarea rows="10" class="form-control" name="content" id="ck_content">{{ $language_obj->content or old('content') }}</textarea>
										</div>
									</div>
									@if($setting_content_tab)
									<?php								
									$option = false;
									if(isset($obj))
									{
										$option = $obj->option;
									}
									$prepair_field = SystemHelper::PrepairField($setting_content_tab->fieldSettings,$option);
									$editor        = array_merge($editor,$prepair_field['ck']);
									?>
									{!! $prepair_field['view'] !!}
									@endif
									<div class="form-group">
										<label class="col-sm-2 control-label" for="title">Tags</label>
										<div class="col-sm-6">										
											<input type="text" id="tags" name="tags" class="form-control" data-role="tagsinput" value="{{$tags or old('tags')}}">
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label" for="title">Parent</label>										
										<div class="col-sm-6">							
											<select id="country-select" name="parent_id" class="select-block-level chzn-select">
												<option value="0">Choose Top Level</option>
												@foreach($parent as $item)		
													<?php $item = $item->translateOrDefault(\Session::get('local_language')); ?>										
													@if(isset($obj)&&$obj->parent_id==$item->id)
														<option selected value="{{$item->id}}">{{strtoupper(@$item->title)}}</option>
													@else
														<option value="{{$item->id}}">
															{{strtoupper(@$item->title)}}
														</option>
													@endif
												@endforeach
											</select>											
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label" for="title">Status</label>										
										<div class="col-sm-6">											
											<select id="country-select" name="status" class="select-block-level chzn-select">
												<option value="1" @if(isset($obj)&&$obj->status==1) selected @endif >Public</option>                                                
												<option value="0" @if(isset($obj)&&$obj->status==0) selected @endif>UnPublic</option>                                                
											</select>											
										</div>
									</div>
								</div>
								<div class="tab-pane" id="attr">
									<legend class="section">Attribute information</legend>
									<div class="form-group">
										<label class="col-sm-2 control-label" for="title">Menu Title</label>
										<div class="col-sm-6">
											<input type="text" name="menu_title" class="form-control"  value="{{$language_obj->menu_title or old('menu_title') }}">
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label" for="title">Slug</label>
										<div class="col-sm-6">
											<input type="text" name="slug" class="form-control"  value="{{$obj->slug or old('slug') }}">
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label" for="title">Sequence</label>
										<div class="col-sm-6">
											<input type="text" name="sequence" class="form-control"  value="{{$obj->sequence or old('sequence') }}">
										</div>
									</div>									
								</div>
								<div class="tab-pane" id="seo">
									<legend class="section">SEO Information</legend>
									<div class="form-group">
										<label class="col-sm-2 control-label" for="title">SEO Title</label>
										<div class="col-sm-6">
											<input type="text" name="seo_title" class="form-control"  value="{{ $language_obj->seo_title or old('title') }}">
										</div>
									</div>
									<div class="form-group">									
										<label class="col-sm-2 control-label" for="title">Meta</label>
										<div class="col-sm-10">
											<textarea rows="10" class="form-control" name="meta" id="meta">{{ $language_obj->meta or old('meta') }}</textarea>
										</div>
									</div>
								</div>
								<div class="tab-pane" id="tab-images">
									<?php
										$upload_image = [];
										$upload_image[] = ['label'=>'Thumbnail Images','target'=>'thumbnail','preview'=>'preview-thumbnail']; // it's col for thumbnail. other use option col.
										$upload_image[] = ['label'=>'Facebook','target'=>'target_facebook','preview'=>'preview-facebook'];	
										$upload_image[] = ['label'=>'Cover','target'=>'target_cover','preview'=>'preview-cover'];										
										foreach ($setting_image_tab->fieldSettings as $item) {
											$upload_image[] = ['label'=>$item->label,'target'=>$item->var,'preview'=>'preview-'.$item->var];
										}
									?>
									@foreach($upload_image as $image)
									<section id="uploader-{{$image['target']}}" data-target="target">
										<legend class="section">{{$image['label']}}</legend>
										<div class="form-group">
											<div class="col-xs-4" style="padding-right:0px;">
												<input type="file" class="choose form-control" id="{{$image['target']}}" name="{{$image['target']}}[]" style="border-radius:0;">
												<input type="hidden" name="target[]" value="{{$image['target']}}">
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
													@endforeach										
												@endif
											@else
												@if(isset($obj)&&$obj->main_images!='')
												<?php							
													$tmp_images = json_decode($obj->main_images);																																																						
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
								</div>
								<div class="tab-pane" id="menu">
									<legend class="section">Menu</legend>
									<div class="form-group">
										@foreach($menus as $menu)
											<div class="col-sm-5">											
												<label for="{{$menu->name}}">
													@if(isset($obj)&&in_array($menu->id,$obj_menu))
														<input name="menu[]" value="{{$menu->id}}" checked="checked" type="checkbox"> {{strtoupper($menu->name)}}
													@else
														<input name="menu[]" value="{{$menu->id}}" type="checkbox"> {{strtoupper($menu->name)}}
													@endif
												</label>
											</div>
										@endforeach
									</div>								
								</div>							
							</div>                                                      
							<div class="form-actions">
								<div class="row">
									<div class="col-sm-10 col-sm-offset-3">
										<div class="btn-toolbar">
											<button type="submit" class="btn btn-success">Submit</button>
											<a href="{{$link_back}}" class="btn btn-default">Cancel</a>
										</div>
									</div>
								</div>
							</div>
						</fieldset>
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
	            data.append("file", file[0]);
	            @if(isset($obj))
		            data.append("obj_id", {{$obj->id}});//You can append as many data as you want. Check mozilla docs for this
	            @endif
	            data.append("type", 'post');
	            if(file[0].size/1000<={{env('MAX_IMAGE')}})
	            {
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
	            }else{
	            	Messenger({
	                type: "error",
	                    extraClasses:'messenger-fixed messenger-on-right messenger-on-top'
	                }).post('your file can not upload. maximum size of image is 1mb');
	            }    
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