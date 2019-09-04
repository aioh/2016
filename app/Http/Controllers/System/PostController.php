<?php namespace App\Http\Controllers\System;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use Request;
use Session;
use Validator;
use App\Post;
use App\Term;
use App\Template;
use App\Menu;
use App\AjaxResponse;
use \App\Helpers\SystemHelper;

class PostController extends Controller {

	protected $data    = [];
	protected $setting = [];
	
	public function __construct()
	{
		$this->middleware('auth');
		$this->data['type']          = 'post';
		$this->data['title']         = 'Post';
		$this->setting['url']        = 'posts';
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
				// 'title'    => 'required',
				'sequence' => 'integer',
			];		
		return $rule;
	}

	public function index()
	{
		$input                      = Request::all('template');		
		$this->data['template']     = $input['template'];
		$this->data['tmp_template'] = \App\Template::where('template','=',$input['template'])->first();	
		$this->data['search']       = '';
		if(isset($input['search']))
		{
			$title = rawurldecode($input['search']);	
			$this->data['search']       = $title;
	        $this->data['posts'] = Post::whereHas('translations', function ($query) use ($title) {
	            $query->where('title','like', '%'.$title.'%');
	        })->where('template_id','=',$this->data['tmp_template']->id)->with('parent')->with('template')->translatedIn()->orderBy('id','DESC')->paginate(10);	
    	}else{
			$this->data['posts']        = Post::where('template_id','=',$this->data['tmp_template']->id)->with('parent')->with('template')->translatedIn()->orderBy('id','DESC')->paginate(10);		
		}		
		return view($this->setting['list_view'],$this->data);
	}

	public function getAjax()
	{
		$input          = Request::all('template');		
		$template       = \App\Template::where('template','=',$input['template'])->first();
		\App::setLocale(Session::get('language_local'));		
		// $return['data'] = Post::where('template_id','=',$template->id)->with('parent')->with('template')->translatedIn()->get();
		$return['data'] = Post::where('template_id','=',$template->id)->with('parent')->with('template')->translatedIn()->get();
		return json_encode($return);
	}	

	public function create()
	{
		$input = Request::all();		
		$this->data['method']              = 'POST';
		$this->data['url']                 = $this->setting['list_link'].'?template='.$input['template'];
		$this->data['link_back']           = $this->setting['list_link'];
		$this->data['parent']    		   = Post::whereHas('template',function($q){
											     $q->where('is_parent','=',1);
									         })->get();
		$this->data['menus']               = Menu::all();
		$this->data['setting_content_tab'] = $this->templateSetting('content',$input['template']);			
		$this->data['setting_image_tab']   = $this->templateSetting('image',$input['template']);	

		return view($this->setting['form_view'],$this->data);
	}

	public function store()
	{
		$input    = Request::all();			
		$validate = Validator::make($input, $this->rule());
	    if ($validate->fails())
	    {
	    	$messages = $validate->messages();
	        return redirect()->back()->withErrors($validate->errors())->withInput();
	    }
	    $template = \App\Template::where('template','=',$input['template'])->first();
	    // dd($input);
	    $obj = new Post();
	    // add main post table	    
	    $input['title'] = trim($input['title']);
	    if($input['slug']!="")
	    {
	    	$slug = trim($input['slug']);
	    }else{
	    	if($input['title']==''){
		    	$slug = 'no-title';
		    }else{
	    		$slug = $input['title'];
	    	}
	    }
		$slug             = SystemHelper::create_slug($slug);
		$obj->slug        = $slug;		
		$obj->status      = $input['status'];
		$obj->author_id   = Auth::user()->id;
		$obj->parent_id   = $input['parent_id'];
		$obj->sequence    = $input['sequence'];
		$obj->template_id = $template->id;

		// update image
		if(isset($input['images']))
		{	
			$post_images       = $input['images'];
			$tmp_images        = [];
			$tmp_option_images = [];
			$tmp_old_image     = [];
			foreach($post_images as $key=>$image)
			{			
				if($key=='thumbnail')
				{
					$size      = sizeof($image['path']);
					for ($i=0; $i < $size; $i++)
					{ 
						$tmp_image            = [];
						$tmp_image['path']    = $image['path'][$i];
						$tmp_image['alt']     = $image['alt'][$i];
						$tmp_image['link']    = $image['link'][$i];					
						$tmp_image['caption'] = $image['caption'][$i];		
						$tmp_images[]         = $tmp_image;	
						$tmp_old_image[]      = $tmp_image['path'];
					}
					$obj->thumbnail = json_encode($tmp_images,true);						
					// unset($tmp_images);
				}else {		
					$size      = sizeof($image['path']);
					for ($i=0; $i < $size; $i++)
					{ 
						$tmp_option_image            = [];
						$tmp_option_image['path']    = $image['path'][$i];
						$tmp_option_image['alt']     = $image['alt'][$i];
						$tmp_option_image['link']    = $image['link'][$i];					
						$tmp_option_image['caption'] = $image['caption'][$i];	
						$tmp_option_images[$key][]   = $tmp_option_image;	
						$tmp_old_image[]             = $tmp_option_image['path'];
					}							
				}			
			}	
			if(isset($tmp_option_images))
			{
				$arr_images = json_encode($tmp_option_images,true);
			}	
			$obj->main_images = $arr_images;
			$obj->old_main_images = json_encode($tmp_old_image);
		}					
		$obj->save();
		// field option		
		$template_field = $this->templateSetting('content',$input['template']);			
		$field_option   = $template_field->fieldSettings;
		$option         = [];
		foreach ($field_option as $item)
		{
			$option[$item->var] = $input[$item->var];
		}
		// add tag
		$obj->terms()->detach();		
		$arry_tags = $this->prepareTag($input['tags']);
		$obj->terms()->attach($arry_tags);

		// add lagnuage
		if($input['menu_title']==''){
			$input['menu_title'] = $input['title'];
		}
		$locale = Session::get('language_local');
		$obj->translateOrNew($locale)->title      = $input['title'];
		$obj->translateOrNew($locale)->content    = $input['content'];		
		$obj->translateOrNew($locale)->menu_title = $input['menu_title'];
		$obj->translateOrNew($locale)->seo_title  = $input['seo_title'];
		$obj->translateOrNew($locale)->meta       = $input['meta'];
		$obj->translateOrNew($locale)->option     = json_encode($option);		
		$obj->save();

		// add menu
		if(isset($input['menu']))
		{
			$menus = $input['menu'];
			$obj->menus()->detach();
			$obj->menus()->attach($menus);
		}		
		$message = 'Create Success';
		\Session::flash('response',$message);
		return redirect('system/posts?template='.$template->template);    
	}

	public function edit($id)
	{
		try
		{	
			$obj                        = Post::findOrFail($id);	
			$this->data['obj']          = $obj;
			$this->data['language_obj'] = $obj->translateOrDefault(Session::get('language_local'));
			$tags              			= $obj->terms;
			$txt_tag 					= '';
			foreach ($tags as $tag) {
				if(end($tags)==$tag)
				{
					$txt_tag .= $tag->name;
				}else{
					$txt_tag .= $tag->name.',';
				}
			}
			$this->data['tags']      = $txt_tag;			
			$this->data['method']    = 'PUT';
			$this->data['url']       = $this->setting['list_link'].'/'.$id.'?template='.$obj->template->template;
			$this->data['link_back'] = url($this->setting['list_link'].'/'.'?template='.$obj->template->template);
			$this->data['parent']    = Post::whereHas('template',function($q){
											$q->where('is_parent','=',1);
									   })->get();
			$this->data['setting_content_tab'] = $this->templateSetting('content',$obj->template->template);			
			$this->data['setting_image_tab']   = $this->templateSetting('image',$obj->template->template);			

			$this->data['menus']    = Menu::all();

			// prepare menu
			$tmp_obj_menu           = $obj->menus;
			$this->data['obj_menu'] = [];
			foreach ($tmp_obj_menu as $menu)
			{
				$this->data['obj_menu'][] = $menu->id;
			}
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
		$validate = Validator::make($input, $this->rule());
	    if ($validate->fails())
	    {
	    	$messages = $validate->messages();
	        return redirect()->back()->withErrors($validate->errors())->withInput();
	    }
	    
	    $obj = Post::find($id);
	    $template = $obj->template->template;
	    // add main post table	    
		$input['title']   = trim($input['title']);
		// dd($input['slug']);
		$slug             = SystemHelper::create_slug($input['slug'],$id);
		$obj->title       = $input['title'];
		$obj->slug        = $slug;		
		$obj->status      = $input['status'];
		$obj->author_id   = Auth::user()->id;
		$obj->parent_id   = $input['parent_id'];
		$obj->sequence    = $input['sequence'];

		// update image
		$delete_thumbnail   = true;
		$delete_extra_image = [];
		if(isset($input['images']))
		{	
			$post_images       = $input['images'];
			$tmp_images        = [];
			$tmp_option_images = [];
			foreach($post_images as $key=>$image)
			{			
				if($key=='thumbnail')
				{
					$size      = sizeof($image['path']);
					for ($i=0; $i < $size; $i++) { 
						$tmp_image            = [];
						$tmp_image['path']    = $image['path'][$i];
						$tmp_image['alt']     = $image['alt'][$i];
						$tmp_image['link']    = $image['link'][$i];					
						$tmp_image['caption'] = $image['caption'][$i];		
						$tmp_images[]         = $tmp_image;		
					}
					$delete_thumbnail = false;
					$obj->thumbnail   = json_encode($tmp_images,true);						
					// unset($tmp_images);
				}else {		
					$delete_extra_image[$key] = false;
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
			}	
			if(isset($tmp_option_images))
			{
				$arr_images = json_encode($tmp_option_images,true);
			}	
		}			
		if($delete_thumbnail)
		{
			$obj->thumbnail = '';
		}
		if(isset($tmp_option_images))
		{
			$arr_images = json_encode($tmp_option_images,true);
		}else{
			$arr_images = '';
		}
		$obj->main_images = $arr_images;
		$obj->save();
		// field option		
		$template_field = $this->templateSetting('content',$input['template']);			
		$field_option   = $template_field->fieldSettings;
		$option         = [];
		foreach ($field_option as $item)
		{
			$option[$item->var] = $input[$item->var];
		}
		// add tag
		$obj->terms()->detach();		
		$arry_tags = $this->prepareTag($input['tags']);
		
		// add lagnuage		
		if($input['menu_title']==''){
			$input['menu_title'] = $input['title'];
		}
		$locale = Session::get('language_local');
		$obj->translateOrNew($locale)->title      = $input['title'];
		$obj->translateOrNew($locale)->content    = $input['content'];
		$obj->translateOrNew($locale)->menu_title = $input['menu_title'];
		$obj->translateOrNew($locale)->seo_title  = $input['seo_title'];
		$obj->translateOrNew($locale)->meta       = $input['meta'];
		$obj->translateOrNew($locale)->option     = json_encode($option);	
		// dd($arr_images);	
		$obj->save();

		// add menu
		if(isset($input['menu']))
		{
			$menus = $input['menu'];
			$obj->menus()->detach();
			$obj->menus()->attach($menus);
		}else{
			$obj->menus()->detach();
		}
		
		$message = 'Update Success';
		\Session::flash('response',$message);
		return redirect('system/posts/'.$id.'/edit?template='.$template);  
	}

	public function destroy($id)
	{		
		try{
		    $obj = Post::findOrFail($id);
		    /*
			for new delete old images feature
		    $old_image = json_decode($obj->old_images);
		    foreach ($old_image as $item)
		    {
		    	Upload::deleteFile($item);
		    }
		    */
		    if($obj->delete())
		    {
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

	public function templateSetting($tab,$template)
	{
		$return = Template::with(array('fieldSettings'=>function($q) use ($tab,$template){
					$q->where('tab','=',$tab);
				}))->where('template','=',$template)->first();					
		return $return;
	}

	public function prepareTag($tags)
	{
		$tags    = explode(',',$tags);
		$old_tag = Term::where('taxonomy','=','tag')->get();
		$tmp_old_tag = [];
		foreach ($old_tag as $item)
		{
			$tmp_old_tag[$item->id] = $item->name;
		}
		$tmp_term_search = [];
		foreach ($tags as $item){
			if($item!='')
			{
				$term_search = array_search($item, $tmp_old_tag);
				if($term_search==null)
				{				
					$term = new Term();
					$term->name = $item;
					$term->taxonomy = 'tag';
					$term->save();
					$term_search = $term->id;
				}			
				$tmp_term_search[] = $term_search;
			}
		}
		return $tmp_term_search;
	}
}
