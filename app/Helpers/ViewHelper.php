<?php namespace App\Helpers;
use Illuminate\Support\Facades\Facade;
use \App\Helpers\ViewHelper;

class ViewHelper extends Facade{

	protected static function getFacadeAccessor() { return 'ViewHelper'; }

	public static function getCountPosts()
	{
		$count =  \App\Post::whereHas('template',function($q){
					$q->where('template','=','post');
				})->count();
		return $count;
	}

	public static function thaiDateFormat($date_time)
	{
		$year = date_format($date_time,'Y');		
		$day = date_format($date_time,'d');
		$thai_months = ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.'];
		$month = $thai_months[date_format($date_time,'m')-1];
		return $day.' '.$month.' '.($year+543);
	}
}
?>