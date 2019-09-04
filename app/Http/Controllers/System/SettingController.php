<?php namespace App\Http\Controllers\System;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use Request;
use Session;
use Validator;
use App\Setting;
use App\AjaxResponse;
use \App\Helpers\SystemHelper;

class SettingController extends Controller {

	protected $data    = [];
	protected $setting = [];
	
	public function __construct()
	{
		$this->middleware('auth');
		$this->data['type']          = 'setting';
		$this->data['title']         = 'Setting';
		$this->setting['url']        = 'settings';
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

	public function rule()
	{
		$rule = [
				'var'   => 'required',
				'label' => 'required',
				'type'  => 'required',
			];		
		return $rule;
	}

	public function index()
	{		
		return view($this->setting['list_view'],$this->data);
	}

	public function getAjax()
	{
		$return['data'] = Setting::all();
		return json_encode($return);
	}	

	public function create()
	{
		$input = Request::all();		
		$this->data['method']              = 'POST';
		$this->data['url']                 = $this->setting['list_link'];
		$this->data['link_back']           = $this->setting['list_link'];			
		return view($this->setting['form_view'],$this->data);
	}	

	public function show()
	{
		$this->data['objs']      = Setting::all();		
		$this->data['url']       = $this->setting['list_link'];			
		$this->data['link_back'] = $this->setting['list_link'];
		$this->data['method']    = 'PUT';
		return view($this->setting['show_view'],$this->data);
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
		$obj        = new Setting();
		$obj->var   = $input['var'];
		$obj->label = $input['label'];
		$obj->type  = $input['type'];
		$obj->save();		
		$message    = 'Create Success';		
		\Session::flash('response',$message);
		return redirect('system/settings');  
	}

	public function edit($id)
	{
		try
		{
			$this->data['obj']    = Setting::find($id);
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
			$input      = Request::all();
			$obj        = Setting::find($id);
			$obj->var   = $input['var'];
			$obj->label = $input['label'];
			$obj->type  = $input['type'];
			$obj->save();		
			$message    = 'Update Success';		
			\Session::flash('response',$message);
			return redirect('system/settings'); 
		}
		catch(ModelNotFoundException $e)
		{
		   	abort(500); 
		} 
	}
	public function save()
	{
		$input = Request::all();			
		unset($input['_token']);
		unset($input['_method']);
		$locale = Session::get('language_local');
		foreach ($input as $key=>$value) {
			$setting = Setting::where('var','=',$key)->first();
			$setting->translateOrNew($locale)->value = $value;
			$setting->save();
		}	
		$message = 'Update Success';		
		\Session::flash('response',$message);
		return redirect('system/settings/show');  
	}

	public function destroy($id)
	{		
		try{
		    $obj = Setting::findOrFail($id);
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
