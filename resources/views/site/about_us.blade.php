@extends('layout.site')

@section('content')
	<section id="aboutus-page">
		<div class="container">
			<div class="row">
				<div id="aboutus" class="page">
					
					<div class="col-xs-12 col-sm-12 col-md-12" style="margin-bottom: 40px;" >
						<div>
							<div id="logo" class="text-center hidden-xs"style="background-color: #fdd400;margin: 30px 0 30px 0;">
								<img src="http://www.fm91bkk.com/assets/site/images/logo.jpg" class="img-responsive margin-center" style="padding-bottom: 30px;padding-top: 30px;">
							</div>
							<!--<div class="banner"></div>
							<label>เกี่ยวกับ สวพ.91</label>
							<div>-------</div>
							<label>27 มิ.ย. 1560</label>
							<div>-------</div>
							<div style="padding:15px;">
								<table>
									<tr style="padding:15px;">
										<td style="text-align: right;" class="col-md-3">
											ความเป็นมา :
										</td>
										<td class="col-md-9">
											xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
										</td>
									</tr>
									<tr style="padding:15px;">
										<td style="text-align: right;" class="col-md-3">
											ความเป็นมา :
										</td>
										<td class="col-md-9">
											xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
										</td>
									</tr>
								</table>
							</div>
							<div>-------</div>-->
							<div>
							{!!$obj_language->content!!}
								
							</div>
						</div>
					</div>
									
				</div>
			</div>
		</div>
	</section>
@stop