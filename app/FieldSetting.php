<?php namespace App;
use Illuminate\Database\Eloquent\Model;

class FieldSetting extends Model {
	
	public function template()
	{
		return $this->belongsTo('\App\Template');
	}
}
