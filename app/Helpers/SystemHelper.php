<?php namespace App\Helpers;
use Illuminate\Support\Facades\Facade;
use \App\Helpers\SystemHelper;

class SystemHelper extends Facade{

	protected static function getFacadeAccessor() { return 'SystemHelper'; }

	public static function PrepairField($fields,$option=false)
	{
		$return['view'] = '';
		$return['ck'] = [];
		$json_option = '';
		if($option){
			$json_option = json_decode($option);
		}		
		foreach ($fields as $field) {
			$data['value'] = '';
			$var = $field->var;
			if(isset($json_option->$var))
			{
				$data['value'] = $json_option->$var;
			}			
			if($field->type=='text')
			{
				$data['field'] = $field;
				$return['view'] .= view('system.render.'.$field->type,$data);
			}else if($field->type=='textarea') {
				$data['field'] = $field;
				$return['ck'][] = $field->var;
				$return['view'] .= view('system.render.'.$field->type,$data);
			}else if($field->type=='date') {
				$data['field'] = $field;
				$return['view'] .= view('system.render.'.$field->type,$data);
			}
		}
		return $return;
	}

	public static function getDefaultLanguage()
	{
		$language = \App\Language::where('default','=',1)->first();
		return $language;
	}

	public static function getTemplatesPost()
	{
		$objs = \App\Template::where('type','=',0)->orderBy('sequence')->get();
		return $objs;
	}

	public static function getTemplatesPage()
	{		
		$objs = \App\Template::with('posts')->where('type','=',1)->orderBy('sequence')->get();
		return $objs;
	}

	public static function loadPreview($image)
	{
		$data['image'] = $image;
		return view('system.forms.upload-image',$data);
	}

	public static function create_slug($string,$id = false)
	{
		$string = mb_substr($string, 0,30);
		$slug = preg_replace('/[^A-Za-z0-9-ก-๙]+/u', '-', $string);
		$check = true;
		$i = 2;
		$tmp_slug = $slug;
		while ($check)
		{
			if($id){
				$temp = \App\Post::where('slug','=',$tmp_slug)->where('id','<>',$id)->count();
			}else{
				$temp = \App\Post::where('slug','=',$tmp_slug)->count();
			}
			if($temp>0){
				$tmp_slug = $slug.'-'.$i++;
			}else{
				$check = false;
			}
		}	
		$slug = $tmp_slug;			
		return strtolower($slug);
	}

	public static function getAllSlider($name)
	{
		$slider  = \App\Slide::where('name','=',$name)->get();
		return $slider;
	}

	public static function getSlider($name)
	{
		$slider      = \App\Slide::where('name','=',$name)->first();
		if(isset($slider))
		{
			$json_slider = json_decode($slider->option);
			return $json_slider->main_image;
		}
		else{
			return null;
		}
	}

	public static function getLanguages()
	{
		$language = \App\Language::all();
		return $language;
	}

	public static function getMenus($name)
	{		
		$menus    = \App\Menu::with('posts')->where('name','=',$name)->first();
		return $menus;		
	}

	public static function getRecommendArticles($post)
	{
		$articles = \App\Post::whereHas('menus', function($q) use ($post) {
			$q->where('id', '=', $post->menus[0]->id);
		})->take(3)->get();
		return $articles;
	}

	public static function getSetting()
	{
		$settings    = \App\Setting::get();
		$arr_setting = [];
		foreach ($settings as $item) {
			$arr_setting[$item->var] = $item->value;
		}
		return $arr_setting;
	}
}
?>