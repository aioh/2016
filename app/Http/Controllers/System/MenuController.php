<?php namespace App\Http\Controllers\System;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use Request;
use Session;
use Validator;
use App\Menu;
use App\AjaxResponse;
use \App\Helpers\SystemHelper;

class MenuController extends Controller {

	protected $data    = [];
	protected $setting = [];
	
	public function __construct()
	{
		$this->middleware('auth');
		$this->data['type']          = 'menu';
		$this->data['title']         = 'Menu';
		$this->setting['url']        = 'menus';
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
			$rule['name'] = 'required|unique:menus,name,'.$id;
		}else{
			$rule['name'] = 'required|unique:menus';
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
		$return['data'] = Menu::all();
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
	    $obj = new Menu();	
	    $obj->name = $input['name'];
	    $obj->save();
		return redirect(url('system/menus'));    
	}

	public function edit($id)
	{
		try
		{
			$this->data['obj']    = Menu::find($id);
			$this->data['data']   = Menu::find($id)->posts;				
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
	    $obj = Menu::find($id);
	    $obj->name = $input['name'];
	    $obj->save();
	    $obj->posts()->detach();
	    $tmp_order = [];
	    $i = 0;
	    if(isset($input['order']))
	    {
		    foreach ($input['order'] as $item) {
		    	$order = [];
		    	$order['post_id'] = $item;
		    	$order['sequence'] = $i++;
		    	$tmp_order[] = $order;
		    }
		}
		$obj->posts()->attach($tmp_order);
		return redirect(url('system/menus/'.$id.'/edit')); 
	}

	public function destroy($id)
	{
		try{
		    $obj = Menu::findOrFail($id);
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
