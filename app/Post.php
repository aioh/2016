<?php namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
	use SoftDeletes;
    use \Dimsav\Translatable\Translatable;

    public $translatedAttributes = ['title', 'content', 'option', 'images', 'menu_title', 'seo_title', 'meta'];

    public function terms()
    {
        return $this->belongsToMany('\App\Term');
    }

     public function user()
    {
    	return $this->belongsTo('\App\Post');
    }

    public function menus()
    {
        return $this->belongsToMany('\App\Menu');
    }

    public function parent()
    {
         return $this->hasOne('App\Post', 'id', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany('App\Post', 'parent_id', 'id')->orderBy('sequence','DESC')->orderBy('created_at','DESC');
    }

    public function template()
    {
        return $this->belongsTo('\App\Template');
    }

    public function last()
    {
        return Post::orderBy('id', 'desc')->first();
    }
}