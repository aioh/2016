<?php namespace App\Http\Controllers\System;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use Request;
use Session;
use Validator;
use App\Slide;
use App\AjaxResponse;
use App\Upload;
use \App\Helpers\SystemHelper;

class SlideController extends Controller {

	protected $data    = [];
	protected $setting = [];
	
	public function __construct()
	{
		$this->middleware('auth');
		$this->data['type']          = 'slider';
		$this->data['title']         = 'Slider';
		$this->setting['url']        = 'sliders';
		$this->setting['route_name'] = get_class($this);
		$this->setting['folder']     = 'system';
		// link to
		$this->setting['create_link'] = $this->setting['folder'].'/'.$this->setting['url'].'/create/';
		$this->setting['list_link']   = $this->setting['folder'].'/'.$this->setting['url'];
		$this->setting['show_link']   = $this->setting['folder'].'/'.$this->setting['url'].'/';
		// view 
		$this->setting['form_view']  = $this->setting['folder'].'.forms.'.$this->data['type'];
		$this->setting['list_view']  = $this->setting['folder'].'.lists.'.$this->data['type'];
		$this->setting['show_view']  = $this->setting['folder'].'.shows.'.$this->data['type'];		
	}

	public function rule($id = false)
	{
		
	}

	public function index()
	{
		return view($this->setting['list_view'],$this->data);
	}

	public function getAjax()
	{
		$return['data'] = Slide::all();
		return json_encode($return);
	}	

	public function create()
	{
		$this->data['method']    = 'POST';
		$this->data['url']       = $this->setting['list_link'];
		$this->data['link_back'] = $this->setting['list_link'];
		return view($this->setting['form_view'],$this->data);
	}
	
	public function store()
	{
		$input             = Request::all();					
		$obj               = new Slide();
		$obj->name         = $input['name'];	
		if(isset($input['images']))
		{
			$images            = $input['images'];
			$tmp_option_images = [];
			$tmp_old_image     = [];
			foreach($images as $key=>$image)
			{						
				$size      = sizeof($image['path']);
				for ($i=0; $i < $size; $i++) { 
					$tmp_option_image            = [];
					$tmp_option_image['path']    = $image['path'][$i];
					$tmp_option_image['alt']     = $image['alt'][$i];
					$tmp_option_image['link']    = $image['link'][$i];					
					$tmp_option_image['caption'] = $image['caption'][$i];	
					$tmp_option_images[$key][]   = $tmp_option_image;
					$tmp_old_image[]             = $tmp_option_image['path'];
				}									
			}		
			if(isset($tmp_option_images))
			{
				$obj->option = json_encode($tmp_option_images,true);
			}
			$obj->save();
			$message        = 'Create Success';
			\Session::flash('response',$message);
		}
		return redirect('system/sliders');
	}

	public function edit($id)
	{
		try
		{
			$this->data['obj']    = Slide::find($id);
			$this->data['url']    = $this->setting['list_link'].'/'.$id;			
			$this->data['method'] = 'PUT';
			$this->data['link_back'] = $this->setting['list_link'];
			return view($this->setting['form_view'],$this->data);
		}
		catch(ModelNotFoundException $e)
		{
		   	abort(500); 
		}
	}

	public function update($id)
	{
		$input = Request::all();					
		$obj       = Slide::find($id);
		$obj->name = $input['name'];	
		if(isset($input['images']))
		{
			$images    = $input['images'];
			$tmp_option_images = [];
			foreach($images as $key=>$image)
			{						
				$size      = sizeof($image['path']);
				for ($i=0; $i < $size; $i++) { 
					$tmp_option_image            = [];
					$tmp_option_image['path']    = $image['path'][$i];
					$tmp_option_image['alt']     = $image['alt'][$i];
					$tmp_option_image['link']    = $image['link'][$i];					
					$tmp_option_image['caption'] = $image['caption'][$i];	
					$tmp_option_images[$key][]   = $tmp_option_image;
				}									
			}		
			if(isset($tmp_option_images))
			{
				$obj->option = json_encode($tmp_option_images,true);
			}
			$obj->save();
			$message        = 'Create Success';
			\Session::flash('response',$message);
		}
		return redirect('system/sliders');
	}

	public function destroy($id)
	{		
		try{
		    $obj = Slide::findOrFail($id);
		    // $old_image = json_decode($obj->old_main_images);
		    // foreach ($old_image as $item)
		    // {
		    // 	Upload::deleteFile($item);
		    // }
		    if($obj->delete()){
		    	$return = new AjaxResponse(200,'Delete Success');
		    	$return->setData(array('delete'=>'tr'));						
			}else{
				$return = new AjaxResponse(503,'Unable to delete');
			}			
		}catch(ModelNotFoundException $e){			
		    $return = new AjaxResponse(404,'Object is not found',$e->getMessage());			
		}		
		return $return->getJson();	
	}
}
