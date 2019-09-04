<?php namespace App\Http\Controllers\System;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use Request;
use Session;
use Validator;
use App\User;
use App\Role;
use App\AjaxResponse;
use \App\Helpers\SystemHelper;

class UserController extends Controller {

	protected $data    = [];
	protected $setting = [];
	
	public function __construct()
	{
		$this->middleware('auth');
		$this->data['type']          = 'user';
		$this->data['title']         = 'User';
		$this->setting['url']        = 'users';
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
			$rule['email'] = 'required|email|max:50|min:6|unique:users,email,'.$id;
		}else{
			$rule = [
				'password'  			=> 'required|min:6|confirmed',
				'password_confirmation' => 'required|min:6',
				'firstname' 			=> 'required',
				'lastname'  			=> 'required',
		    ];	
			$rule['email'] = 'required|email|max:50|min:6|unique:users';			
		}
		return $rule;
	}

	public function index()
	{
		return view($this->setting['list_view'],$this->data);
	}

	public function getAjax()
	{
		$return['data'] = User::all();
		return json_encode($return);
	}	

	public function create()
	{
		$this->data['method']    = 'POST';
		$this->data['url']       = $this->setting['list_link'];
		$this->data['link_back'] = $this->setting['list_link'];
		$this->data['roles']     = Role::all();
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
		$obj            = new User();
		$obj->email     = $input['email'];
		$obj->password  = \Hash::make($input['password']);
		$obj->firstname = $input['firstname'];
		$obj->lastname  = $input['lastname'];
		$obj->role_id   = $input['role_id'];
		$obj->save();
		$message         = 'Create Success';
		\Session::flash('response',$message);
		return redirect('system/users');
	}

	public function edit($id)
	{
		try
		{
			$this->data['roles']  = Role::all();
			$this->data['obj']    = User::find($id);
			$this->data['url']    = $this->setting['list_link'].'/'.$id;			
			$this->data['method'] = 'PUT';
			$this->data['link_back'] = $this->setting['list_link'];
			return view('system.forms.user',$this->data);
		}
		catch(ModelNotFoundException $e)
		{
		   	abort(500); 
		}
	}

	public function update($id)
	{
		$input = \Request::all();
		if(isset($input['password']))
		{
			$rule = ['password'  	=> 'required|min:6|confirmed',
					 'password_confirmation' => 'required|min:6',];
		}else{
			$rule = $this->rule($id);
		}
		$validate = \Validator::make($input, $rule);
	    if ($validate->fails())
	    {
	        return redirect()->back()->withErrors($validate->errors());
	    }else{
			$obj            = User::find($id);
			if(isset($input['password']))
			{
				$obj->password   = \Hash::make($input['password']);
			}else{
				$obj->email     = $input['email'];
				$obj->firstname = $input['firstname'];
				$obj->lastname  = $input['lastname'];
				$obj->role_id   = $input['role_id'];
			}					
			$obj->save();
			$message         = 'Update successful';
			\Session::flash('response',$message);
			return redirect('system/users');
	    }
	}

	public function destroy($id)
	{
		try{
		    $obj = User::findOrFail($id);
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
