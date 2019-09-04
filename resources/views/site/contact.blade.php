@extends('layout.site')

@section('content')
	<section id="contact-page">
		<div class="container">
			<div class="row">
				<div id="contact" class="page">
					
					<div class="col-sm-6">
						<div class="map">
							{!!$setting['google_map']!!}
						</div>
					</div>
					<div class="col-sm-6">
						<div class="contact">
							<div class="contact-info">
								<h3>{!!$setting['contact_header']!!}</h3>
								<hr>
								<p>	
									{!!$setting['contact_address']!!}
								</p>
								<hr>
								<p>{{$setting['tel']}} {{$setting['text_tel']}}</p>
							</div>
							{!! Form::open(array('url' => url('sending'),'class'=>'contact-form','method'=>'post')) !!}
								<h3><u>{{$setting['contact_text']}}</u></h3>
								<div class="each-form">
									<div class="row">
										<label for="name" class="col-sm-3">{{$setting['form_name']}}</label>
										<div class="col-sm-9">
											<input type="text" name="name" class="form-control" >
										</div>
									</div>
								</div>
								<div class="each-form">
									<div class="row">
										<label for="email" class="col-sm-3">{{$setting['form_email']}}</label>
										<div class="col-sm-9">
											<input type="email" name="email" class="form-control" >
										</div>
									</div>
								</div>
								<div class="each-form">
									<div class="row">
										<label for="detail" class="col-sm-3">
											{{$setting['form_content']}}
										</label>
										<div class="col-sm-9">
											<textarea name="detail" class="form-control" rows="3"></textarea>
										</div>
									</div>
								</div>
								<div class="each-form">
									<div class="row">
										<div class="col-sm-3"></div>
										<div class="col-sm-9">
											<div class="text-center">
												<button class="btn my-btn">ส่ง</button>
												{{Session::get('email_response')}}
											</div>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>					
				</div>
			</div>
		</div>
	</section>
@stop