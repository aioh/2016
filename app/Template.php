<?php namespace App;
use Illuminate\Database\Eloquent\Model;

class Template extends Model {
	
	public function fieldSettings()
	{
		return $this->hasMany('\App\FieldSetting');
	}

	public function posts()
	{
		return $this->hasMany('\App\Post');
	}
}
