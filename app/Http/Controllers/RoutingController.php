<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use Mail;
use Request;
use Session;
use Validator;
use App\Post;
use App\Term;
use App\Counter;
use App\Language;
use \App\Helpers\SystemHelper;
use DateTime;

class RoutingController extends Controller {

	protected $data    = [];
	protected $setting = [];

	public function index()
	{
		// Check View		
		$datetime = date('Y-m-d H:i:s',strtotime("-1 days"));
		$ip = Request::getClientIp();	
		// $counter = Counter::where('ip','=',$ip)->where('created_at','>',$datetime)->count();
		$counter = Counter::where('ip','=',$ip)->count();
		if($counter==0){
			$counter = new Counter();
			$counter->ip = $ip;
			$counter->save();
		}				
		$default_language = SystemHelper::getDefaultLanguage();
		$locale = Session::get('language_local');						
		if($locale=='')
		{			
			Session::put('language_local', $default_language->key);						
			$locale = $default_language->key;
		}	
		$segments = Request::path();
		$url = '';
		if($segments!="/")
		{
			$uri = explode('/', $segments);
			$last = urldecode(end($uri));
			$obj = Post::with('template')->where('slug','=',$last)->first();	
			$url = $last;
		}else{
			$obj = $obj = Post::with(array('template'=>function($q){
				$q->where('template','=','index');
			}))->first();				
			$url = 'index';
		}
		if($obj==null)
		{
			abort(404);
		}				
		$data['counter']             = Counter::orderBy('created_at','desc')->first()->id;		
		$data['setting']             = SystemHelper::getSetting();		
		$data['obj']                 = $obj;
		$data['obj_option']          = json_decode($obj->option);
		$data['obj_language']        = $obj->translateOrDefault($locale);
		$data['obj_language_option'] = json_decode($data['obj_language']->option);		
		$data['children']            = $obj->children()->where('status','=',1)->paginate($obj->template->pagination);
		return view('site.'.$obj->template->template,$data);
	}

	public function sending()
	{
		$input     = Request::all();				
		Mail::send('site.email',$input, function($message)
		{
		    $message->from(env('EMAIL'));
		    $message->to(env('EMAIL'))->subject('Send from Website');
		});
		$response = 'ส่งข้อมูลเรียบร้อยแล้ว';
		\Session::flash('email_response',$response);
		return redirect(url('ติดต่อเรา'));  
	}

	public function search()
	{
		// Check View		
		$datetime = date('Y-m-d H:i:s',strtotime("-1 days"));
		$ip = Request::getClientIp();	
		// $counter = Counter::where('ip','=',$ip)->where('created_at','>',$datetime)->count();
		$counter = Counter::where('ip','=',$ip)->count();
		if($counter==0){
			$counter = new Counter();
			$counter->ip = $ip;
			$counter->save();
		}

		$search = \Request::get('search');
		$posts = \App\Post::whereHas('translations', function($q) use($search)
		{
			$q->where('template_id','=',2);
		    $q->where(function($query) use ($search)
	        {
	            $query->where('title', 'like', '%'.$search.'%')
	            ->orwhere('content', 'like', '%'.$search.'%');
	        });
		})->where('status','=',1)->paginate(20);	
		
		$data['counter']             = Counter::orderBy('created_at','desc')->first()->id;		
		$data['setting']             = SystemHelper::getSetting();
		$data['posts']               = $posts;		
		$data['search']              = $search;		
		return view('site.search',$data);
	}
}
