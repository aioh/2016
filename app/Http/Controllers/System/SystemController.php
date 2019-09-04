<?php namespace App\Http\Controllers\System;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Request;
use Session;
use Auth;
use Upload;
use \App\Post;
use \App\Slide;

class SystemController extends Controller {

	public $data = [];
	
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function dashboard()
	{
		$this->data['post_count']     = Post::all()->count();		
		$this->data['post_new']       = Post::take(5)->get();
		$this->data['user_new']       = \App\User::take(5)->get();
		$this->data['slide_new']      = \App\Slide::take(5)->get();
		$this->data['user_count']     = \App\User::all()->count();
		$this->data['slide_count']    = \App\Slide::all()->count();
		$this->data['language_count'] = \App\Language::all()->count();		
		return view('system.dashboard',$this->data);
	}

	public function uploadFileFrom($id=false)
	{				
		$this->data['obj'] = Post::find($id);
		$this->data['obj_option'] = json_decode($this->data['obj']->option);
		return view('system.forms.upload-image',$this->data);	
	}

	public function loadPreview()
	{
		$input                = Request::all();
		$json                 = json_decode($input['data']);		
		$this->data['path']   = $json[0]->path;
		$this->data['target'] = $input['target'];
		$tmp                  = explode('.', $json[0]->path);
		$image_extension      = ['png','jpg','gif']; // if change here, you have to change in post form render image too.
		if(in_array(end($tmp),$image_extension)){			
			return view('system.forms.ajax-preview',$this->data);
		}else{
			return view('system.forms.ajax-preview-file',$this->data);
		}
	}
	public function uploadFile()
	{		
		$upload = new \App\Upload();
		$input  = Request::all();				
		$return = $upload->uploadFile('file');
		$path   = json_decode($return)[0]->path;
		if(isset($input['obj_id']))
		{
			$id = $input['obj_id'];
			if($input['type']=='post')
			{
				$obj = Post::find($id);
				if($obj->old_main_images!='')
				{
					$tmp = @json_decode($obj->old_main_images);
					$tmp = array_merge($tmp,[$path]);
				}else{
					$tmp[] = $path;
				}		
				$obj->old_main_images = json_encode($tmp);
				$obj->save();
			}else if($input['type']=='slide'){
				// $obj = Slide::find($id);
				// if($obj->old_main_images!='')
				// {
				// 	$tmp = @json_decode($obj->old_main_images);
				// 	$tmp = array_merge($tmp,[$path]);
				// }else{
				// 	$tmp[] = $path;
				// }		
				// $obj->old_main_images = json_encode($tmp);
				// $obj->save();
			}	
		}			
		return $return;		
	}

	public function deleteFile()
	{
		$input = Request::all();
		// $path = $input['path'];
		// \File::delete($path);		
	}
}
