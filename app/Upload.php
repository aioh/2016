<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Upload extends Model{
	
	public $path;

	function uploadFile($input_name)
	{
		$input           = \Input::file($input_name);
		$files = [];
		if(!is_array($input))
		{
			$files[0] = $input;
		}else{
			$files = $input;
		}
		$ret_files = [];
		foreach ($files as $file) {
			if(isset($file))
			{
				$extenstion = strtolower($file->getClientOriginalExtension());
				$path       = $this->getUploadPath();				
				$file_name  = $file->getClientOriginalName();
				$file_name  = str_replace(' ', '_', $file_name);
				$file_name  = explode('.', $file_name);
				unset($file_name[sizeof($file_name)-1]);
				$file_name  = implode('.', $file_name);
				// echo $path.$file_name.'.'.$extenstion;
				$file_name       = strtolower($file_name);
				while (file_exists($path.$file_name.'.'.$extenstion)) {
				 	$file_name       = strtolower($file_name.'_'.strtolower(str_random(4)));
				}				
				$uploadSuccess   = $file->move($path, $file_name.'.'.$extenstion);
				$ret_files[] = ['path'=>$path.strtolower($file_name.'.'.$extenstion),'alt'=>'','link'=>'','caption'=>'','type'=>''];
			}
		}
		$return = '';
		// if(!is_array($input)){
		// 	$return = $ret_files[0];
		// }else{
		// 	$return = json_encode($ret_files);
		// }
		$return = json_encode($ret_files);
		return $return;
	}

	public function getUploadPath()
	{
		$target_folder = env('UPLOAD_PATH');
		if(substr($target_folder, -1) != '/')
			$target_folder .= '/';

		//Check Year folder		
		$target_folder .= date('Y-m/');
		if(!file_exists($target_folder))
		{
			if(!is_dir($target_folder))
			{
				mkdir($target_folder);
			}
		}
		return $target_folder;
	}
		

	public static function deleteFile($file_path)
	{
		$check = @unlink($file_path);		
		return $check;
	}
}
?>