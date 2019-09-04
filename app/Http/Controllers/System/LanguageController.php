<?php namespace App\Http\Controllers\System;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use Request;
use Session;
use Validator;
use App\Language;
use App\AjaxResponse;

class LanguageController extends Controller {

	protected $data    = [];
	protected $setting = [];
	
	public function __construct()
	{
		$this->middleware('auth');		
		$this->data['type']          = 'language';
		$this->data['title']         = 'language';
		$this->setting['url']        = 'languages';
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
		if($id){
			$rule['name'] = 'required|unique:languages,name,'.$id;
			$rule['key']  = 'required|unique:languages,key,'.$id;
		}else{
			$rule['name'] = 'required|unique:languages';
			$rule['key']  = 'required|unique:languages,key';
		}
		return $rule;
	}

	public function index()
	{			
		return view($this->setting['list_view'],$this->data);
	}

	public function getAjax()
	{
		$input = Request::all('template');		
		$return['data'] = language::all();
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
	    $obj = new Language();	
		$obj->name    = $input['name'];
		$obj->key     = $input['key'];
		$obj->default = $input['default'];
		if($obj->default==1)
		{
			$languages = Language::all();
			foreach($languages as $item){
				$item->default = 0;
				$item->save();
			}
		}
	    $obj->save();
	    $message = 'Create Success';
		\Session::flash('response',$message);
		return redirect(url('system/languages'));    
	}

	public function edit($id)
	{
		try
		{
			$this->data['obj']    = Language::find($id);				
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
		$validate = Validator::make($input, $this->rule($id));
	    if ($validate->fails())
	    {
	    	$messages = $validate->messages();
	        return redirect()->back()->withErrors($validate->errors())->withInput();
	    }
	    $obj = language::find($id);
	    $obj->name    = $input['name'];
		$obj->key     = $input['key'];
		$obj->default = $input['default'];
		if($obj->default==1)
		{
			$languages = Language::all();
			foreach($languages as $item){
				$item->default = 0;
				$item->save();
			}
		}
		$obj->save();
	    $message = 'Update Success';
		\Session::flash('response',$message);
		return redirect(url('system/languages')); 
	}

	public function destroy($id)
	{
		try{
		    $obj = language::findOrFail($id);
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
