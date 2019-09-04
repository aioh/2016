<?php namespace App\Http\Controllers\System;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use Request;
use Session;
use Validator;
use App\Template;
use App\AjaxResponse;
use \App\Helpers\SystemHelper;

class TemplateController extends Controller {

	protected $data    = [];
	protected $setting = [];
	
	public function __construct()
	{
		$this->middleware('auth');
		$this->data['type']          = 'template';
		$this->data['title']         = 'Template';
		$this->setting['url']        = 'templates';
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
		$rule = [
			'template' => 'required'
	    ];
	    return $rule;
	}

	public function index()
	{		
		return view($this->setting['list_view'],$this->data);
	}

	public function getAjax()
	{
		$return['data'] = Template::all();
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
		$input = Request::all();			
		$validate = Validator::make($input, $this->rule());
	    if ($validate->fails())
	    {
	    	$messages = $validate->messages();
	        return redirect()->back()->withErrors($validate->errors())->withInput();
	    }
	    $obj = new Template();
		$obj->template   = $input['template'];
		$obj->is_delete  = $input['is_delete'];
		$obj->is_create  = $input['is_create'];
		$obj->is_show    = $input['is_show'];
		$obj->is_parent  = $input['is_parent'];
		$obj->type       = $input['type'];
		$obj->pagination = $input['pagination'];
		$obj->save();
		$message         = 'Create Success';
		\Session::flash('response',$message);
		return redirect('system/templates');
	}

	public function edit($id)
	{
		try
		{
			$this->data['obj']    = Template::find($id);
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
		try
		{
			$input = Request::all();			
			$validate = Validator::make($input, $this->rule());
		    if ($validate->fails())
		    {
		    	$messages = $validate->messages();
		        return redirect()->back()->withErrors($validate->errors())->withInput();
		    }
		    $obj = Template::find($id);
			$obj->template   = $input['template'];
			$obj->is_delete  = $input['is_delete'];
			$obj->is_create  = $input['is_create'];
			$obj->is_show    = $input['is_show'];
			$obj->is_parent  = $input['is_parent'];
			$obj->type       = $input['type'];
			$obj->pagination = $input['pagination'];
			$obj->save();
			$obj->fieldSettings()->delete();
			if(isset($input['extra_label']))
			{
				$size = sizeof($input['extra_label']);
				for ($i=0; $i < $size; $i++) { 
					$field_setting                = [];
					$field_setting['label']       = $input['extra_label'][$i];
					$field_setting['var']         = $input['extra_var'][$i];
					$field_setting['sequence']    = $i;
					$field_setting['type']        = $input['extra_type'][$i];
					$field_setting['tab']         = 'content';										
					$field_setting['template_id'] = $obj->id;
					$obj->fieldSettings()->insert($field_setting);
				}
			}

			if(isset($input['extra_image_label']))
			{
				$size = sizeof($input['extra_image_label']);
				$extra_field_label = [];
				for ($i=0; $i < $size; $i++) { 
					$field_setting                = [];
					$field_setting['label']       = $input['extra_image_label'][$i];
					$field_setting['var']         = $input['extra_image_var'][$i];
					$field_setting['sequence']    = $i;
					$field_setting['type']        = 'image';
					$field_setting['tab']         = 'image';										
					$field_setting['template_id'] = $obj->id;
					$obj->fieldSettings()->insert($field_setting);
				}
			}
			$message         = 'Update Success';
			\Session::flash('response',$message);
			return redirect('system/templates/'.$id.'/edit');
		}
		catch(ModelNotFoundException $e)
		{
		   	abort(500); 
		}
	}

	public function addField()
	{
		return view('system.forms.ajax-setting-field');
	}

	public function addImage()
	{
		return view('system.forms.ajax-setting-image');
	}
	
	public function destroy($id)
	{		
		try{
		    $obj = Template::findOrFail($id);
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
