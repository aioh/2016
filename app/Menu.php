<?php namespace App;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model {
	
	public function posts()
	{
		return $this->belongsToMany('\App\Post')->withPivot('sequence')->orderBy('pivot_sequence', 'asc');

	}
}
