@extends('layout/admin')

@section('content')
    <h2 class="page-title">{{$title}} <small>form</small></h2>
    <div class="row">
        <div class="col-md-7">
            <section class="widget">
                <header>
                    <h4><i class="fa fa-user"></i> Account Profile <small>Create new or edit existing user</small></h4>
                </header>
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
                            <legend class="section">User Info</legend>
                            <div class="form-group">
                                <label class="control-label col-sm-4" for="email">Email <span class="required">*</span></label>
                                <div class="col-sm-8"><input type="email" id="email" name="email" required="required" class="form-control" value="{{$obj->email or old('email')}}"></div>
                            </div>
                            <?php
                                if(!isset($obj)){
                            ?>
                            <div class="form-group">
                                <label class="control-label col-sm-4" for="password">Password <span class="required">*</span></label>
                                <div class="col-sm-8"><input type="password" id="password" name="password" required="required" class="form-control" ></div>
                            </div> 
                            <div class="form-group">
                                <label class="control-label col-sm-4" for="password">Confirm Password <span class="required">*</span></label>
                                <div class="col-sm-8"><input type="password" id="password" name="password_confirmation" required="required" class="form-control" ></div>
                            </div>    
                            <?php } ?>                            
                            <div class="form-group">
                                <label class="control-label col-sm-4" for="first-name">First Name <span class="required">*</span></label>
                                <div class="col-sm-8"><input type="text" id="first-name" name="firstname" required="required" class="form-control" value="{{$obj->firstname or old('firstname')}}"></div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4" for="last-name">Last Name <span class="required">*</span></label>
                                <div class="col-sm-8"><input type="text" id="last-name" name="lastname" required="required"  class="form-control" value="{{$obj->lastname or old('lastname')}}"></div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4">Role<span class="required">*</span></label>
                                <div class="col-sm-8">
                                	<select name="role_id" class="form-control">
                            			<option value="">Choose Role</option>
                            			@foreach($roles as $role)
                            				@if(isset($obj)&&$obj->role_id==$role->id)
	                                    		<option selected value="{{$role->id}}">{{$role->name}}</option>
                                    		@else
	                                    		<option value="{{$role->id}}">{{$role->name}}</option>
                                    		@endif
                                		@endforeach
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
                    </form>
                    <?php if(isset($obj)){ ?>
                    {!! Form::open(array('url'=>$url,'method'=>$method,'class'=>'form-horizontal','id'=>'article-form','files'=>true))!!}                                                                 
                        <fieldset>                  
                            <legend class="section">Change Password</legend>                                                    
                            <div class="form-group">
                                <label class="control-label col-sm-4" for="password">Password <span class="required">*</span></label>
                                <div class="col-sm-8"><input type="password" id="password" name="password" required="required" class="form-control" ></div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4" for="password">Confirm Password <span class="required">*</span></label>
                                <div class="col-sm-8"><input type="password" id="password" name="password_confirmation" required="required" class="form-control" ></div>
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
                    <?php } ?>
                </div>
            </section>
        </div>        
    </div>
    </div>
    <div class="loader-wrap hiding hide">
        <i class="fa fa-circle-o-notch fa-spin"></i>
    </div>
@stop